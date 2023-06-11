<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class job_work_activities extends Model
{
    use HasFactory;

    protected $fillable = ['job_id','work_activity_id'];
}
