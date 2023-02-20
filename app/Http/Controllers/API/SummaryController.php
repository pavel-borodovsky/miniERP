<?php

namespace App\Http\Controllers\API;

use App\Services\SummaryTable;
use App\Http\Controllers\Controller;

class SummaryController extends Controller
{
    public function __invoke() {
        $summaryTable = new SummaryTable();
        return response($summaryTable->getInvoices());
    }
}
