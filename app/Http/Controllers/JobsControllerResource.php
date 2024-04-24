<?php

namespace App\Http\Controllers;

use App\Http\Actions\GetRoleAction;
use App\Http\Controllers\Filters\DescFilter;
use App\Http\Controllers\Filters\IdFiltter;
use App\Http\Controllers\Filters\NameFilter;
use App\Http\Controllers\Filters\TagFilter;
use App\Http\Repositaries\JobRepobsitary;
use App\Http\Requests\jobsFormRequest;
use App\Http\Resources\JobResource;
use App\Http\traits\messages;
use App\Models\job_abilities;
use App\Models\job_competencies;
use App\Models\job_interests;
use App\Models\job_knowledge;
use App\Models\job_principle_contracts;
use App\Models\job_skills;
use App\Models\job_tasks;
use App\Models\job_work_activities;
use App\Models\job_work_values;
use App\Models\jobs;
use App\Models\job_certificates;
use App\Models\job_educations;
use App\Models\job_work_contexts;
use App\Models\roles;
use App\Models\work_activities;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;

class JobsControllerResource extends Controller
{

    public function __construct(){
        $this->middleware('CheckApiAuth')->only('store');
        $this->middleware('CheckApiAuth')->only('update');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = jobs::query()
            ->with(['certificates','abilities','knowledge','educations','work_contexts','skills','tasks'])
            ->orderBy('id','DESC')
            ->paginate(50);
        return JobResource::collection($data);
    }

    public function jobs_names(){
        $data = jobs::query()
            ->select('id','ar_name','en_name')
            ->orderBy('id','DESC');

        $output = app(Pipeline::class)
            ->send($data)
            ->through([
                IdFiltter::class,
                NameFilter::class,
                DescFilter::class,
                TagFilter::class
            ])
            ->thenReturn()
            ->paginate(50);
        return JobResource::collection($output);
    }

    public function ids(){
        return jobs::query()->select('id')->get();
    }

    public function jobs_dash(){

        $data = jobs::query()
            ->with(['parent'=>function($e){
                return $e->select('id',app()->getLocale().'_name as name');
            }])
            ->orderBy('id','DESC');

        $output = app(Pipeline::class)
            ->send($data)
            ->through([
                NameFilter::class,
                DescFilter::class,
                TagFilter::class
            ])
            ->thenReturn()
            ->paginate(25);

        return messages::success_output('',$output);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function parents(){
        $data = jobs::query()
            ->select('id',app()->getLocale().'_name as name')
            ->where('parent_id','=',0)
            ->orWhere('parent_id','=',null)
            ->orderBy('id','DESC')->get();

        return messages::success_output('',$data);
    }

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
            ->save_data_model($data['job_certificates'] ?? [],job_certificates::class,'certificates')
            ->save_data_model($data['job_abilities'] ?? [],job_abilities::class,'abilities')
            ->save_data_model($data['job_knowledge'] ?? [],job_knowledge::class,'knowledge')
            ->save_data_model($data['job_competencies'] ?? [],job_competencies::class,'competencies')
            ->save_data_model($data['job_educations'] ?? [],job_educations::class,'educations')
            ->save_data_model($data['job_work_contexts'] ?? [],job_work_contexts::class,'work_contexts')
            ->save_data_model($data['job_work_activities'] ?? [],job_work_activities::class,'work_activities')
            ->save_data_model($data['job_work_values'] ?? [],job_work_values::class,'work_values')
            ->save_data_model($data['job_tasks'] ?? [],job_tasks::class,'tasks')
            ->save_data_model($data['job_skills'] ?? [],job_skills::class,'skills')
            ->save_data_model($data['job_interests'] ?? [],job_interests::class,'interests')
            ->save_data_model($data['job_principle_contracts'] ?? [],job_principle_contracts::class,'principle_contracts');
        DB::commit();
        return messages::success_output(trans('messages.operation_done_successfully'),$job->get_job());
    }

    public function save_job_info_only(jobsFormRequest $formRequest)
    {
        //
        $data = $formRequest->validated();
        $data['user_id'] = auth()->id();
        $job = new JobRepobsitary();
        $job_data = array_filter($data, function($value) {
            return !is_array($value);
        });

        DB::beginTransaction();
        $job->save_job($job_data);
        return JobResource::make($job->get_job());
    }

    public function store(jobsFormRequest $formRequest)
    {
        //
       $this->middleware('CheckApiAuth');
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
            ->with(['certificates','principle_contracts','parent'=>function($e){
                $e->select('id',app()->getLocale().'_name as name');
            },'abilities','competencies','knowledge','educations','work_values','interests',
                  'work_activities'
                ,'work_contexts','skills','job_skills.skill','tasks'])
            ->find($id);
        if(request()->has('admin')){
            return messages::success_output('',$data);
        }
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
