<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['user_id', 'rate'];

    public function listCards() {
        return $this->belongsToMany(ListCard::class)->using(MemberCard::class);
    }
}
