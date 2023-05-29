<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobCertificatesResource extends JsonResource
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
          'name'=>$this->name,
          'image'=>$this->image,
          'created_at'=>$this->created_at->format('Y m d, h:i A'),
        ];
    }
}
