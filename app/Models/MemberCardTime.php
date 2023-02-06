<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberCardTime extends Model
{
    use HasFactory;
    protected $table = 'members_cards_time';
    protected $fillable = ['spent_time', 'date', 'members_cards_id'];

    public function memberCard() {
        return $this->belongsTo(MemberCard::class);
    }
}
