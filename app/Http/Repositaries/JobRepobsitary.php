<?php


namespace App\Http\Repositaries;


use App\Http\Actions\HandleMultiLangData;
use App\Models\jobs;
use App\Http\traits\upload_image;
use Illuminate\Support\Str;

class JobRepobsitary
{
    use upload_image;
    private $job;
    public function save_job($data){
        $this->job = jobs::query()->updateOrCreate([
            'id'=>array_key_exists('id',$data) ? $data['id']:null
        ],$data);
        return $this;
    }

    public function save_data_model($data,$model){
        foreach($data as $d) {
            $d['job_id'] = $this->job->id;

            $d = HandleMultiLangData::handle_data($d);

            resolve($model)->updateOrCreate([
                'id'=>array_key_exists('id',$d) ? $d['id']:null
            ],$d);
        }
        return $this;
    }
}
