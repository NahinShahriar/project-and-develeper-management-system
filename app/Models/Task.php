<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Task extends Model
{
    use HasFactory,softDeletes;

    protected $fillable = [
        'title','project_id' ,'description', 'due_date', 'status', 'assigned_to',
    ];

    public function project() {
    return $this->belongsTo(Project::class);
    }

    public function assignedUser() {
    return $this->belongsTo(User::class, 'assigned_to');
    }

    public function assignbyUser(){
        return $this->belongsTo(User::class,'assigned_by');
    }

}
