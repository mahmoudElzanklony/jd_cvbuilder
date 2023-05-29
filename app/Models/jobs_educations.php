<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jobs_educations extends Model
{
    use HasFactory;

    protected $fillable = ['job_id','year_work_experience','note'];
}
