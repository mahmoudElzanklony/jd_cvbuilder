<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
          'id'=>$this->id,
          'user_id'=>$this->user_id,
          'name'=>$this->{app()->getLocale().'_name'},
          'description'=>$this->{app()->getLocale().'_desc'},
          'parent_id'=>$this->parent_id,
          'career_ladder'=>$this->career_ladder,
          'contract_period'=>$this->contract_period,
          'contract_renewable'=>$this->contract_renewable,
          'years_experience'=>$this->years_experience,
          'min_salary'=>$this->min_salary,
          'max_salary'=>$this->max_salary,
          'career_path'=>$this->career_path,
          'created_at'=>$this->created_at != null ? $this->created_at->format('Y m d, h:i A') : '',
          'certificates'=>JobCertificatesResource::collection($this->whenLoaded('certificates')),
          'abilities'=>JobAbilitiesResource::collection($this->whenLoaded('abilities')),
          'knowledge'=>JobKnowledgeResource::collection($this->whenLoaded('knowledge')),
          'educations'=>JobEducationResource::collection($this->whenLoaded('educations')),
          'work_contexts'=>JobWorkContextResource::collection($this->whenLoaded('work_contexts')),
          'skills'=> JobSkillsResource::collection($this->whenLoaded('job_skills')),
          'tasks'=>JobTasksResource::collection($this->whenLoaded('tasks')),
          'work_values'=>JobWorkValueResource::collection($this->whenLoaded('work_values')),
          'work_activities'=>JobWorkActivitiesResource::collection($this->whenLoaded('work_activities')),
          'interests'=>JobInterestsResource::collection($this->whenLoaded('interests')),
          'principle_contracts'=>JobInterestsResource::collection($this->whenLoaded('principle_contracts')),
        ];
    }
}
