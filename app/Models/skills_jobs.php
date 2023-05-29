<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class skills_jobs extends Model
{
    use HasFactory;

    protected $fillable = ['job_id','skill_id','importance','mastery'];
}
