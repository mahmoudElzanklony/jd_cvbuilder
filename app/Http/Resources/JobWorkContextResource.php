<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobWorkContextResource extends JsonResource
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
            'title'=>$this->{app()->getLocale().'_title'},
            'description'=>$this->{app()->getLocale().'_desc'},
            'note'=>$this->note,
           // 'rank'=>$this->rank,
            'created_at'=>$this->created_at != null ? $this->created_at->format('Y m d, h:i A') : '',
        ];
    }
}
