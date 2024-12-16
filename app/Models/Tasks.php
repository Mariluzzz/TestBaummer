<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Collaborators;

class Tasks extends Model
{
    use HasFactory;
    
    public $timestamps = false; 

    protected $fillable = [
        'description', 'deadline', 'collaborator_id', 'priority', 'created_at', 'executed_at'
    ];

    public function collaborator()
    {
        return $this->belongsTo(Collaborators::class, 'collaborator_id', 'id');
    }
}
