<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Filters\DescFilter;
use App\Http\Controllers\Filters\EmailFilter;
use App\Http\Controllers\Filters\EndDateFilter;
use App\Http\Controllers\Filters\NameFilter;
use App\Http\Controllers\Filters\SkGroupIdFilter;
use App\Http\Controllers\Filters\StartDateFilter;
use App\Http\Controllers\Filters\TitleFilter;
use App\Http\Controllers\Filters\UsernameFilter;
use App\Http\Requests\countriesFormRequest;
use App\Http\Requests\SkillsFormRequest;
use App\Http\Resources\SkillsResource;
use App\Http\Resources\TitleDescResource;
use App\Http\Resources\UserResource;
use App\Http\traits\messages;
use App\Models\countries;
use App\Models\skills;
use App\Models\skills_groups;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class DashboardController extends Controller
{
    //

    public function users(){
        $data = User::query()->with('country')->orderBy('id','DESC');
        $output = app(Pipeline::class)
            ->send($data)
            ->through([
                UsernameFilter::class,
                StartDateFilter::class,
                EndDateFilter::class
            ])
            ->thenReturn()
            ->paginate(25);
        return UserResource::collection($output);
    }

    public function get_skills(){
        $data = skills::query()->with('sk_group',function($e){
            $e->select('id',app()->getLocale().'_title as title');
        })->orderBy('id','DESC');
        $output = app(Pipeline::class)
            ->send($data)
            ->through([
                TitleFilter::class,
                SkGroupIdFilter::class,
                StartDateFilter::class,
                EndDateFilter::class
            ])
            ->thenReturn()
            ->paginate(25);
        return messages::success_output('',$output);
    }

    public function save_skills(SkillsFormRequest $formRequest){
        $data = $formRequest->validated();
        $output = skills::query()->updateOrCreate([
            'id'=>request()->has('id') ? request('id'):null
        ],$data);
        $output = skills::query()->with('sk_group',function($e){
            $e->select('id',app()->getLocale().'_title as title');
        })->find($output->id);
        return messages::success_output(trans('messages.saved_successfully'),$output);

    }

    public function get_sk_groups(){
        $data = skills_groups::query()->orderBy('id','DESC');
        $output = app(Pipeline::class)
            ->send($data)
            ->through([
                TitleFilter::class,
                StartDateFilter::class,
                EndDateFilter::class
            ])
            ->thenReturn()
            ->paginate(25);
        return TitleDescResource::collection($output);
    }

    public function countries(){
        $data = countries::query()->orderBy('id','DESC');
        $output = app(Pipeline::class)
            ->send($data)
            ->through([
                NameFilter::class,
                StartDateFilter::class,
                EndDateFilter::class
            ])
            ->thenReturn()
            ->paginate(25);
        return messages::success_output('',$output);
    }

    public function save_countries(countriesFormRequest $formRequest){
        $data = $formRequest->validated();
        $output = countries::query()->updateOrCreate([
            'id'=>request()->has('id') ? request('id'):null
        ],$data);

        return messages::success_output(trans('messages.saved_successfully'),$output);

    }
}
