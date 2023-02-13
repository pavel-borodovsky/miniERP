<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MemberCard extends Pivot
{
    protected $table = 'members_cards';
    public $incrementing = true;

    protected $fillable = ['est_hour'];
    public $timestamps = false;

    public function memberCardTime() {
        return $this->hasMany(MemberCardTime::class);
    }
}
