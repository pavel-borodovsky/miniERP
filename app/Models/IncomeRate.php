<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeRate extends Model
{
    use HasFactory;
    protected $fillable = ['invoice_task_id', 'member_id', 'rate', 'hours'];

    public function invoiceTask() {
        return $this->belongsTo(InvoiceTask::class);
    }
}
