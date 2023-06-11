<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class jobs extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['user_id','name','parent_id','career_ladder','description','contract_period'
        ,'contract_renewable','years_experience','min_salary','max_salary','career_path'];

    public function certificates(){
        return $this->hasMany(job_certificates::class,'job_id');
    }

    public function abilities(){
        return $this->hasMany(job_abilities::class,'job_id');
    }

    public function knowledge(){
        return $this->hasMany(job_knowledage::class,'job_id');
    }

    public function educations(){
        return $this->hasMany(job_educations::class,'job_id');
    }

    public function work_context(){
        return $this->hasMany(job_work_context::class,'job_id');
    }

    public function skills(){
        return $this->hasMany(skills_jobs::class,'job_id');
    }

    public function tasks(){
        return $this->hasMany(job_tasks::class,'job_id');
    }




}
