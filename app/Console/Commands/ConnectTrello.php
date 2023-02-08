<?php

namespace App\Console\Commands;

use App\Mail\SynchTrelloMessage;
use App\Models\Board;
use App\Models\BoardList;
use App\Models\ListCard;
use App\Models\Member;
use App\Models\MemberCard;
use App\Models\MemberCardTime;
use App\Models\User;
use App\Services\TrelloApi;
use Faker\Generator;
use Illuminate\Console\Command;
use Illuminate\Container\Container;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ConnectTrello extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'synch:trello';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Getting data via API Trello and updating model\'s data';
    //используется в кач-ве букера
    protected $memberId = 'test_tale';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $createdBoards = $updatedBoards = $createdLists = $updatedLists = $createdCards = $updatedCards = $cardsWithMultipleTags = 0;
        $message = 'При синхронизации с Trello были выделены карточки с несколькими тегами: ';
        $api = new TrelloApi();
        //todo реализовать получение данных для всех букеров
        $boards = $api->getBoardsByMember($this->memberId);
        foreach ($boards as $board) {
            $existBoard = Board::find($board['id']);
            $data = [
                'idBoard' => $board['id'],
                'name' => $board['name']
            ];
            if (!$existBoard) {
                Board::create($data);
                $createdBoards++;
            } else {
                $existBoard->update($data);
                $updatedBoards++;
            }

            $lists = $api->getListsByBoard($board['id']);
            foreach ($lists as $list) {
                $existList = BoardList::find($list['id']);
                $data = [
                    'idList' => $list['id'],
                    'name' => $list['name'],
                    'pos' => $list['pos'],
                    'idBoard' => $list['idBoard']
                ];
                if (!$existList) {
                    BoardList::create($data);
                    $createdLists++;
                } else {
                    $existList->update($data);
                    $updatedLists++;
                }
            }
            $cards = $api->getCardsByBoard($board['id']);
            foreach ($cards as $card) {
                //creating or adding card
                $existCard = ListCard::find($card['id']);
                $tag = null;
                $countTags = Str::substrCount($card['name'], ' #');
                if ($countTags > 0) {
                    $tags = Str::substr($card['name'], mb_strpos($card['name'], '#'));
                    if ($countTags == 1) {
                        $tag = $tags;
                    } else {
                        $tags = explode(' ', $tags);
                        $tag = $tags[0];
                        $message .= "<br/>$card[name]";
                        $cardsWithMultipleTags++;
                    }
                }
                $data = [
                    'idCard' => $card['id'],
                    'name' => $card['name'],
                    'pos' => $card['pos'],
                    'due' => $card['due'],
                    'idList' => $card['idList'],
                    'urlSource' => $card['shortUrl'], //or $card['url']
                    'invoice_task_tag' => $tag == '#tag' ? $tag : null
                ];
                if (!$existCard) {
                    ListCard::create($data);
                    $createdCards++;
                } else {
                    $existCard->update($data);
                    $updatedCards++;
                }

                //check members for card
                $tempMember = null;
                $members = $api->getMembersOfCard($card['id']);
                foreach ($members as $member) {
                    $tempMember = Member::find($member['id']);
                    if (!$tempMember) {
                        //adding user with faker's help
                        $faker = Container::getInstance()->make(Generator::class);
                        $user = User::create([
                            'name' => $member['username'],
                            'email' => $faker->unique()->safeEmail(),
                            'password' => $faker->password(),
                            'isActive' => 0
                        ]);

                        $tempMember = Member::create([
                            'id' => $member['id'],
                            'user_name' => $member['username'],
                            'user_id' => $user->id
                        ]);
                    }
                    //check existing that relation
                    if (!$tempMember->listCards->find($card['id'])) {
                        $tempMember->listCards()->attach($card['id']);
                        //storing old value member without relation, need to rewrite
                        $tempMember = Member::find($member['id']);
                    }
                }

                $comments = $api->getCommentsByCard($card['id']);

                //no reason to check comments without members linked with card
                if($tempMember != null) {
                    foreach ($comments as $comment) {
                        $tempMember->listCards->find($card['id']);
                        $text = $comment['data']['text'];
                        //adding estimate hour into pivot table
                        if (Str::startsWith($text, 'plus! 0/')) {
                            $time = $this->getTimeFromComment($comment['data']['text']);
                            $estHour = $time[1];
                            $tempMember->listCards()->updateExistingPivot($card['id'], ['est_hour' => $estHour]);
                        }
                        if (Str::startsWith($text, 'plus! ')) {
                            $time = $this->getTimeFromComment($text);
                            $note = $this->getNoteFromComment($text);
                            $memberCardId = MemberCard::where(['list_card_idCard' => $card['id'], 'member_id' => $tempMember->id])->first()->id;
                            if ($time[0] > 0 && MemberCardTime::where(['members_cards_id' => $memberCardId, 'date' => Carbon::parse($comment['date'])->format('Y-m-d H:i:s'), 'spent_time' => (double)$time[0]])->first() == null) {
                                MemberCardTime::create([
                                    'spent_time' => (double)$time[0],
                                    'date' => Carbon::parse($comment['date'])->format('Y-m-d H:i:s'),
                                    'note' => $note ?? null,
                                    'members_cards_id' => $tempMember->listCards->find($card['id']) ? $tempMember->listCards->find($card['id'])->pivot->id : ''
                                ]);
                            }
                        }
                    }
                }
            }
        }
        $this->info("Boards has been created: $createdBoards");
        $this->info("Boards has been updated: $updatedBoards");
        $this->info("Lists has been created: $createdLists");
        $this->info("Lists has been updated: $updatedLists");
        $this->info("Cards has been created: $createdCards");
        $this->info("Cards has been updated: $updatedCards");

        if($cardsWithMultipleTags > 0) {
            $message .= '<br/>Сохранился только первый тег, остальные были проигнорированы.';
            $users = User::all();
            foreach ($users as $user) {
                if ($user->isAdmin()) {
                    Mail::to($user->email)->send(new SynchTrelloMessage($message));
                }
            }
        }
        return Command::SUCCESS;
    }

    public function getTimeFromComment(string $comment)
    {
        return explode('/', explode(' ', $comment)[1]);
    }

    public function getNoteFromComment(string $comment)
    {
        $arr = explode(' ', $comment);
        unset($arr[0]);
        unset($arr[1]);
        return implode(' ', $arr);
    }

    public function sendMessage($recipient, $message) {
        mail($recipient, 'Synchronize trello tags', $message);
    }
}
