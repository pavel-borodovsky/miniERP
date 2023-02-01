<?php

namespace App\Console\Commands;

use App\Models\Board;
use App\Models\BoardList;
use App\Models\ListCard;
use App\Services\TrelloApi;
use Illuminate\Console\Command;

class ConnectTrello extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'connect:trello';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Getting data via API Trello and updating model\'s data';
    //todo убрать, когда будут реализованы мемберы
    protected $memberId = 'test_tale';
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $createdBoards = $updatedBoards = $createdLists = $updatedLists = $createdCards = $updatedCards = 0;
        $api = new TrelloApi();
        //todo реализовать получение данных для всех букеров
        $boards = $api->getBoardsByMember($this->memberId);
        foreach ($boards as $board) {
            $existBoard = Board::find($board['id']);
            $data = [
                'idBoard' => $board['id'],
                'name' => $board['name']
            ];
            if(!$existBoard) {
                Board::create($data);
                $createdBoards++;
            }
            else {
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
                if(!$existList) {
                    BoardList::create($data);
                    $createdLists++;
                }
                else {
                    $existList->update($data);
                    $updatedLists++;
                }
            }
            $cards = $api->getCardsByBoard($board['id']);
            foreach ($cards as $card) {
                $existCard = ListCard::find($card['id']);
                $data = [
                    'idCard' => $card['id'],
                    'name' => $card['name'],
                    'pos' => $card['pos'],
                    'due' => $card['due'],
                    'idList' => $card['idList'],
                    'urlSource' => $card['shortUrl'] //or $card['url']
                ];
                if(!$existCard) {
                    ListCard::create($data);
                    $createdCards++;
                }
                else {
                    $existCard->update($data);
                    $updatedCards++;
                }
            }

        }
        //todo заменить info на log
        $this->info("Boards has been created: $createdBoards");
        $this->info("Boards has been updated: $updatedBoards");
        $this->info("Lists has been created: $createdLists");
        $this->info("Lists has been updated: $updatedLists");
        $this->info("Cards has been created: $createdCards");
        $this->info("Cards has been updated: $updatedCards");
        return Command::SUCCESS;
    }
}
