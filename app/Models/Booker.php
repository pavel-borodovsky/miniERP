<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booker extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'trello_token'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
