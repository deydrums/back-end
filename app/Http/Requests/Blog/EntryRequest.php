<?php

namespace App\Http\Requests\Blog;
use App\Models\Entry;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class EntryRequest extends FormRequest
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

    public function getEntry()
    {
        $entry_id = $this->id;

        if(Entry::where('id', $entry_id)->doesntExist()) {
            return null;
        }

        $entry = Entry::whereId($entry_id)->first();

        return $entry;

    }
}
