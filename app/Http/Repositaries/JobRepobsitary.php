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

    public function save_data_model($data,$model,$function = ''){
        if($function == 'principle_contracts'){
            foreach($data as $d) {
                $d['job_id'] = $this->job->id;
                resolve($model)->updateOrCreate([
                    'id'=>array_key_exists('id',$d) ? $d['id']:null
                ],$d);
            }
        }else {
            $output_data = [];

            if ($function == 'work_context') {
                $works_ids = collect($data)->map(function ($e) {
                    return $e['work_id'];
                });
                for ($i = 0; $i < sizeof($works_ids); $i++) {
                    $output_data[$works_ids[$i]] = ['rank' => $data[$i]['rank']];
                }
            } else if ($function == 'education') {
                $educations_ids = collect($data)->map(function ($e) {
                    return $e['education_id'];
                });
                for ($i = 0; $i < sizeof($educations_ids); $i++) {
                    $output_data[education_id[$i]] = ['year_work_experience' => $data[$i]['year_work_experience']];
                }
            } else if ($function == 'skills') {
                $skill_ids = collect($data)->map(function ($e) {
                    return $e['skill_id'];
                });
                for ($i = 0; $i < sizeof($skill_ids); $i++) {
                    $output_data[$skill_ids[$i]] = [
                        'importance' => $data[$i]['importance'],
                        'mastery' => $data[$i]['mastery']
                    ];
                }
            }else{
                $output_data = $data;
            }
            //$job = jobs::query()->find($this->job->id);
            $this->job->{$function}()->sync($output_data);
        }
        return $this;
    }
}
