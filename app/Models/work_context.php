<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class work_context extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['title','description','note'];
}
