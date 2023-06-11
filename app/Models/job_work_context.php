<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class job_work_context extends Model
{
    use HasFactory;

    protected $fillable = ['job_id','work_id','rank'];
}
