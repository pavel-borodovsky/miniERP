<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListCard extends Model
{
    use HasFactory;

    protected $primaryKey = 'idCard';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['idCard', 'name', 'idList', 'pos', 'due', 'urlSource', 'invoice_task_tag'];

    public function boardList() {
        return $this->belongsTo(BoardList::class, 'idList');
    }

    public function members() {
        return $this->belongsToMany(Member::class, 'members_cards')->using(MemberCard::class)->withPivot('id', 'est_hour');
    }

    public function invoiceTask() {
        return $this->belongsTo(InvoiceTask::class, 'invoice_task_tag');
    }
}
