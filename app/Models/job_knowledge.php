<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class job_knowledge extends Model
{
    protected $table = 'job_knowledge';
    use HasFactory;

    protected $fillable = ['job_id','knowledge_id'];

}
