<?php

namespace App\Http\Controllers;

use App\Http\Actions\GetRoleAction;
use App\Http\Actions\HandleMultiLangData;
use App\Http\Controllers\Filters\ArDescFilter;
use App\Http\Controllers\Filters\DescFilter;
use App\Http\Controllers\Filters\NameFilter;
use App\Http\Controllers\Filters\ArTitleFilter;
use App\Http\Controllers\Filters\EndDateFilter;
use App\Http\Controllers\Filters\EnDescFilter;
use App\Http\Controllers\Filters\EnNameFilter;
use App\Http\Controllers\Filters\EnTitleFilter;
use App\Http\Controllers\Filters\StartDateFilter;
use App\Http\Repositaries\JobRepobsitary;
use App\Http\Requests\jobsFormRequest;
use App\Http\Resources\JobResource;
use App\Http\traits\messages;
use App\Models\job_abilities;
use App\Models\job_competencies;
use App\Models\job_interests;
use App\Models\job_knowledage;
use App\Models\job_principle_contracts;
use App\Models\job_skills;
use App\Models\job_tasks;
use App\Models\job_work_activities;
use App\Models\job_work_values;
use App\Models\jobs;
use App\Models\job_certificates;
use App\Models\job_educations;
use App\Models\job_work_context;
use App\Models\roles;
use App\Models\work_activities;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;

class JobsControllerResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = jobs::query()
            ->with(['certificates','abilities','knowledge','educations','work_context','skills','tasks'])
            ->orderBy('id','DESC')
            ->paginate(25);
        return JobResource::collection($data);
    }

    public function jobs_names(){
        $data = jobs::query()
            ->select('id','ar_name','en_name')
            ->orderBy('id','DESC');

        $output = app(Pipeline::class)
            ->send($data)
            ->through([
                NameFilter::class,
                DescFilter::class
            ])
            ->thenReturn()
            ->paginate(25);
        return JobResource::collection($output);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function save_job_data($data){
        $data['user_id'] = auth()->id();
        $job = new JobRepobsitary();
        $job_data = array_filter($data, function($value) {
            return !is_array($value);
        });
        /*$job_obj = jobs::query()->find(10);
        return $job_obj->certificates()->sync([1]);*/
        DB::beginTransaction();
        $job->save_job($job_data)
            ->save_data_model($data['job_certificates'],job_certificates::class,'certificates')
            ->save_data_model($data['job_abilities'],job_abilities::class,'abilities')
            ->save_data_model($data['job_knowledage'],job_knowledage::class,'knowledge')
            ->save_data_model($data['job_competencies'],job_competencies::class,'competencies')
            ->save_data_model($data['job_educations'],job_educations::class,'educations')
            ->save_data_model($data['job_work_context'],job_work_context::class,'work_context')
            ->save_data_model($data['job_work_activities'],job_work_activities::class,'work_activities')
            ->save_data_model($data['job_work_values'],job_work_values::class,'work_values')
            ->save_data_model($data['job_tasks'],job_tasks::class,'tasks')
            ->save_data_model($data['skills_jobs'],job_skills::class,'skills')
            ->save_data_model($data['job_interests'],job_interests::class,'interests')
            ->save_data_model($data['job_principle_contracts'],job_principle_contracts::class,'principle_contracts');
        DB::commit();
        return messages::success_output(trans('messages.operation_done_successfully'));
    }

    public function store(jobsFormRequest $formRequest)
    {
        //
        $data = $formRequest->validated();
       return $this->save_job_data($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data = jobs::query()
            ->with(['certificates','abilities','knowledge','educations','work_values','interests',
                  'work_activities'
                ,'work_context','job_skills.skill','tasks'])
            ->find($id);
        //return $data;
        return JobResource::make($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,jobsFormRequest $formRequest, $id)
    {
        //
        $data = $formRequest->validated();
        $data['id'] = $id;
        return $this->save_job_data($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $job = jobs::query()->find($id);
        $role = GetRoleAction::get_role();
        if($job != null && $role->name == 'admin'){
                $job->delete();
                return messages::success_output(trans('messages.deleted_successfully'));
        }
    }
}
