<?php

namespace App\Http\Requests;

use App\Models\Topic;
use App\Models\Discussion;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreDiscussionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // set this to true or false depending on whether you want to allow a user to be authorized or not in order to access this request class
        return auth()->user()->can('create', Discussion::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'max:255'],
            'body'  => ['required'],
            'topic_id' => ['required', Rule::exists(Topic::class, 'id')]
        ];
    }
}
