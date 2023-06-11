<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class job_interests extends Model
{
    use HasFactory;
    protected $fillable = ['job_id','interest_id'];
}
