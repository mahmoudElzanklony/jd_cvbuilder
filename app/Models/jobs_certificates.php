<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class jobs_certificates extends Model
{
    use HasFactory;

    protected $fillable = ['job_id','name','image'];

}
