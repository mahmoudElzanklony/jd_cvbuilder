<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobSkillsResource extends JsonResource
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
            'job_id'=>$this->job_id,
            'skill_id'=>$this->skill_id,
            'importance'=>$this->importance,
            'mastery'=>$this->mastery,
            'created_at'=>$this->created_at->format('Y m d, h:i A'),
        ];
    }
}
