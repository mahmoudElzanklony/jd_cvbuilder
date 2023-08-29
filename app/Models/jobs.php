<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class jobs extends Model
{

    protected $table = 'jobs_data';

    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['user_id','ar_name','en_name','parent_id','career_ladder'
        ,'ar_desc','en_desc','contract_period'
        ,'contract_renewable','years_experience','min_salary','max_salary','ar_career_path','en_career_path'];


    public function parent(){
        return $this->belongsTo(jobs::class,'parent_id');
    }

    public function certificates(){
        return $this->belongsToMany(certificates::class,job_certificates::class,'job_id',
            'certificate_id');
    }

    public function abilities(){
        return $this->belongsToMany(abilities::class,job_abilities::class,'job_id',
            'ability_id');
    }

    public function knowledge(){
         return $this->belongsToMany(knowledge::class,job_knowledge::class,'job_id',
            'knowledge_id');
    }

    public function educations(){
        return $this->belongsToMany(educations::class,job_educations::class,'job_id',
            'education_id');
    }


    public function skills(){
        return $this->belongsToMany(skills::class,job_skills::class,'job_id',
            'skill_id');
    }

    public function job_skills(){
        return $this->hasMany(job_skills::class,'job_id');
    }

    public function tasks(){
        return $this->belongsToMany(tasks::class,job_tasks::class,'job_id',
            'task_id');
    }

    public function competencies(){
        return $this->belongsToMany(competencies::class,job_competencies::class,'job_id',
            'competency_id');
    }


    public function interests(){
        return $this->belongsToMany(interests::class,job_interests::class,'job_id',
            'interest_id');
    }

    public function work_contexts(){
        return $this->belongsToMany(work_contexts::class,job_work_contexts::class,'job_id',
            'work_id');
    }

    public function work_activities(){
        return $this->belongsToMany(work_activities::class,job_work_activities::class,
            'job_id', 'work_activity_id');
    }

    public function work_values(){
        return $this->belongsToMany(work_values::class,job_work_values::class,
            'job_id', 'work_value_id');
    }

    public function principle_contracts(){
        return $this->hasMany(job_principle_contracts::class,'job_id');
    }



}
