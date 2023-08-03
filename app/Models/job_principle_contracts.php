<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class job_principle_contracts extends Model
{
    use HasFactory;

    protected $fillable = ['job_id','ar_name','en_name','end_date','ar_requirements','en_requirements'];
}
