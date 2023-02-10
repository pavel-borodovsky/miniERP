<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceTask extends Model
{
    use HasFactory;
    protected $fillable = ['invoice_id', 'desc', 'fix_price', 'tag'];

    public function invoice() {
        return $this->belongsTo(Invoice::class);
    }

    public function incomeRates() {
        return $this->hasMany(IncomeRate::class);
    }

    public function listCards() {
        return $this->hasMany(ListCard::class, 'invoice_task_tag');
    }
}
