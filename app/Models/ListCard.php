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
}
