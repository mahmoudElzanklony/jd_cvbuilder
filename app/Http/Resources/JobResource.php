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
          'name'=>$this->name,
          'description'=>$this->description,
          'parent_id'=>$this->parent_id,
          'career_ladder'=>$this->career_ladder,
          'contract_period'=>$this->contract_period,
          'contract_renewable'=>$this->contract_renewable,
          'years_experience'=>$this->years_experience,
          'min_salary'=>$this->min_salary,
          'max_salary'=>$this->max_salary,
          'career_path'=>$this->career_path,
          'created_at'=>$this->created_at->format('Y m d, h:i A'),
          'certificates'=>JobCertificatesResource::collection($this->whenLoaded('certificates')),
          'abilities'=>JobAbilitiesResource::collection($this->whenLoaded('abilities')),
          'knowledge'=>JobKnowledgeResource::collection($this->whenLoaded('knowledge')),
          'educations'=>JobEducationResource::collection($this->whenLoaded('educations')),
          'work_context'=>JobWorkContextResource::collection($this->whenLoaded('work_context')),
          'skills'=>JobSkillsResource::collection($this->whenLoaded('skills')),
          'tasks'=>JobTasksResource::collection($this->whenLoaded('tasks')),
        ];
    }
}
