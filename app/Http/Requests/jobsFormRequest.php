<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class jobsFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ar_name'=>'required|max:191',
            'en_name'=>'required|max:191',
            'parent_id'=>'required',
            'career_ladder'=>'required',
            'ar_description'=>'required',
            'en_description'=>'required',
            'contract_period'=>'required',
            'contract_renewable'=>'required',
            'years_experience'=>'required',
            'min_salary'=>'required',
            'max_salary'=>'required',
            'ar_career_path'=>'required',
            'en_career_path'=>'required',
            "job_certificates"    => "filled|array",
            "job_certificates.*"  => "filled",
            "job_abilities"    => "filled|array",
            "job_abilities.*"  => "filled",
            "job_knowledage"    => "filled|array",
            "job_knowledage.*"  => "filled",
            "job_educations"    => "required|array",
            "job_educations.*"  => "required",
            "job_tasks"    => "filled|array",
            "job_tasks.*"  => "filled",
            "job_work_context"    => "required|array",
            "job_work_context.*"  => "required",
            "skills_jobs"    => "required|array",
            "skills_jobs.*"  => "required",
        ];
    }

    public function messages()
    {
        return [
            'ar_name'=>trans('keywords.name'),
            'en_name'=>trans('keywords.name'),
            'parent_id'=>trans('keywords.parent'),
            'career_ladder'=>trans('keywords.career_ladder'),
            'ar_description'=>trans('keywords.ar_description'),
            'en_description'=>trans('keywords.en_description'),
            'contract_period'=>trans('keywords.contract_period'),
            'contract_renewable'=>trans('keywords.contract_renewable'),
            'years_experience'=>trans('keywords.years_experience'),
            'min_salary'=>trans('keywords.min_salary'),
            'max_salary'=>trans('keywords.max_salary'),
            'ar_career_path'=>trans('keywords.ar_career_path'),
            'en_career_path'=>trans('keywords.en_career_path'),
        ];
    }
}
