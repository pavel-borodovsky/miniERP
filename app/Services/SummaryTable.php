<?php

namespace App\Services;

use App\Models\MemberCard;
use App\Models\Project;

class SummaryTable
{
    public function getInvoices() {
        $result = [];
        $projects = Project::all();
        foreach ($projects as $project) {
            $invoices = $project->invoices;
            foreach ($invoices as $invoice) {
                $budget = 0;
                $resultMembers = [];
                $tasks = $invoice->invoiceTasks;
                foreach ($tasks as $task) {
                    $budget += $task->fix_price ?: 0;
                    $cards = $task->listCards;
                    foreach ($cards as $card) {
                        $members = $card->members;
                        foreach ($members as $member) {
                            $resultMembers[$member->user_name] = [
                                'rate' => $member->rate,
                                'est' => 0,
                                'spent' => 0
                            ];
                            $spentTimeForCard = 0;
                            $memberCardTimes = MemberCard::where(['list_card_idCard' => $card->idCard, 'member_id' => $member->id])->first()->memberCardTime;
                            foreach ($memberCardTimes as $time) {
                                $spentTimeForCard += $time->spent_time;
                            }
                            $resultMembers[$member->user_name]['est'] += $member->listCards->find($card->idCard)->pivot->est_hour;
                            $resultMembers[$member->user_name]['spent'] += $spentTimeForCard;
                        }
                    }
                    $expenses = 0;
                    foreach ($resultMembers as $name => $member) {
                        $resultMembers[$name]['total'] = $member['rate'] * $member['spent'];
                        $expenses += $resultMembers[$name]['total'];
                    }
                }
                $result['invoices'][] = [
                    'project' => $project->name,
                    'invoice' => $invoice->date,
                    'status' => $invoice->status->name,
                    'budget' => $budget,
                    'members' => $resultMembers,
                    'expenses' => $expenses,
                    'profit' => $budget - $expenses
                ];
            }
        }
        return $result;
    }
}
