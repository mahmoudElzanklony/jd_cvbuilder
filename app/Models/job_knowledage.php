<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class job_knowledage extends Model
{
    use HasFactory;

    protected $fillable = ['job_id','knowledge_id'];

}
