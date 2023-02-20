<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Services\SummaryTable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SummaryController extends Controller
{
    public function __invoke(Request $request): RedirectResponse|View {
        $summaryTable = new SummaryTable();
        $result = $summaryTable->getInvoices();
        $result['member_count'] = Member::count();
        return view('result', ['result' => $result]);
    }
}
