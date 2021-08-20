<?php

namespace App\Http\Requests\Portafolio;
use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class ProjectRequest extends FormRequest
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

        ];
    }

    public function getProject()
    {
        $project_id = $this->id;

        if(Project::where('id', $project_id)->doesntExist()) {
            return null;
        }

        $project = Project::whereId($project_id)->first();

        return $project;

    }
}
