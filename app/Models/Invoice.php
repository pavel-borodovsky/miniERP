<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = ['project_id', 'date', 'name', 'idBoard', 'status_id'];

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function invoiceTasks() {
        return $this->hasMany(InvoiceTask::class);
    }

    public function board() {
        return $this->belongsTo(Board::class, 'idBoard');
    }

    public function status() {
        return $this->belongsTo(Status::class);
    }
}
