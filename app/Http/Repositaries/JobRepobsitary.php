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

    public function get_job(){
        $job = $this->job;
        if($job->parent_id > 0) {
            $job['parent'] = jobs::query()->where('id', '=', $job->parent_id)->first();
        }
        return $job;
    }

    public function save_data_model($data,$model,$function = ''){
        if($function == 'principle_contracts'){
            /*foreach($data as $d) {
                $d['job_id'] = $this->job->id;
                resolve($model)->updateOrCreate([
                    'id'=>array_key_exists('id',$d) ? $d['id']:null
                ],$d);
            }*/
        }else {

            $output_data = collect($data)->map(function ($e){
               $e = json_decode($e,true);
               return $e['key'];
            });

            if(sizeof($output_data) > 0) {
                //$job = jobs::query()->find($this->job->id);
               // $this->job->{$function}()->sync($output_data->toArray());
                $this->job->{$function}()->sync($output_data);
            }
        }
        return $this;
    }
}
