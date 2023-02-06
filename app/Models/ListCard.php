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
    protected $fillable = ['idCard', 'name', 'idList', 'pos', 'due', 'urlSource'];

    public function boardList() {
        return $this->belongsTo(BoardList::class);
    }

    public function members() {
        return $this->belongsToMany(Member::class)->using(MemberCard::class);
    }
}
