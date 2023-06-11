<?php

namespace App\Http\Controllers;

use App\Http\Actions\GetRoleAction;
use App\Http\Actions\HandleMultiLangData;
use App\Http\Repositaries\JobRepobsitary;
use App\Http\Requests\jobsFormRequest;
use App\Http\Resources\JobResource;
use App\Http\traits\messages;
use App\Models\job_abilities;
use App\Models\job_knowledage;
use App\Models\job_tasks;
use App\Models\jobs;
use App\Models\job_certificates;
use App\Models\job_educations;
use App\Models\job_work_context;
use App\Models\roles;
use App\Models\skills_jobs;
use Illuminate\Http\Request;

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
            ->paginate(10);
        return JobResource::collection($data);
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
        $job->save_job(HandleMultiLangData::handle_data($job_data))
            ->save_data_model($data['job_certificates'],job_certificates::class)
            ->save_data_model($data['job_abilities'],job_abilities::class)
            ->save_data_model($data['job_knowledage'],job_knowledage::class)
            ->save_data_model($data['job_educations'],job_educations::class)
            ->save_data_model($data['job_work_context'],job_work_context::class)
            ->save_data_model($data['job_tasks'],job_tasks::class)
            ->save_data_model($data['skills_jobs'],skills_jobs::class);
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
            ->with(['certificates','abilities','knowledge','educations','work_context','skills','tasks'])
            ->find($id);
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
