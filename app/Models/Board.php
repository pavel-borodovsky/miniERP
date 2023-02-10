<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    protected $primaryKey = 'idBoard';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['idBoard', 'name'];

    public function boardLists() {
        return $this->hasMany(BoardList::class, 'idBoard');
    }

    public function invoices() {
        return $this->hasMany(Invoice::class, 'idBoard');
    }
}
