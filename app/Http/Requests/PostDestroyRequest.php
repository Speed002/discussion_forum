<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostDestroyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // you can choose which policy to call in here to authorize this action,
        // but always make sure it is aligned with the prefix.
        // if the action is a post action, then you call the policy that is within the post policy
        return auth()->user()->can('delete', $this->post);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
