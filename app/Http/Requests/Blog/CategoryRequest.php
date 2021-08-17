<?php

namespace App\Http\Requests\Blog;
use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CategoryRequest extends FormRequest
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

    public function getCategory()
    {
        $category_id = $this->id;

        if(Category::where('id', $category_id)->doesntExist()) {
            return null;
        }

        $category = Category::whereId($category_id)->first();

        return $category;

    }
}
