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
            'skill'=>SkillsResource::make($this->whenLoaded('skill')),
            'importance'=>$this->importance,
            'mastery'=>$this->mastery,
            'created_at'=>$this->created_at != null ? $this->created_at->format('Y m d, h:i A') : '',
        ];
    }
}
