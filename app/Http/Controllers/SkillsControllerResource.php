<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Filters\ArDescFilter;
use App\Http\Controllers\Filters\ArTitleFilter;
use App\Http\Controllers\Filters\EndDateFilter;
use App\Http\Controllers\Filters\EnDescFilter;
use App\Http\Controllers\Filters\EnTitleFilter;
use App\Http\Controllers\Filters\StartDateFilter;
use App\Http\Requests\SkillsFormRequest;
use App\Http\Resources\SkillsResource;
use App\Http\traits\messages;
use App\Models\skills;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class SkillsControllerResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $skills =  skills::query()->orderBy('id','DESC');
        // filter data
        $data = app(Pipeline::class)
            ->send($skills)
            ->through([
                StartDateFilter::class,
                EndDateFilter::class,
                ArTitleFilter::class,
                EnTitleFilter::class,
                ArDescFilter::class,
                EnDescFilter::class,
            ])
            ->thenReturn()
            ->paginate(25);
        return SkillsResource::collection($data);
    }

    public function save($data){
        return  skills::query()->updateOrCreate([
           'id'=>array_key_exists('id',$data) ? $data['id']:null
        ],$data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , SkillsFormRequest $formRequest)
    {
        //
        $data = $this->save($formRequest->validated());
        return messages::success_output(trans('messages.saved_successfully'),$data);

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

        $skill = skills::query()->with('sk_group')->find($id);
        if($skill != null){
            return SkillsResource::make($skill);
        }else{
            return messages::error_output(trans('errors.there_is_no_data_to_preview'));
        }
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id , SkillsFormRequest $formRequest)
    {
        //
        $data = $this->save($formRequest->validated());
        return messages::success_output(trans('messages.updated_successfully'),$data);
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
    }
}
