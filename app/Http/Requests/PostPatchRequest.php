<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostPatchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool //this returns a boolean true or false
    {
        // can the user edit this post -> Well, only the authenticated user can edit this post, not anyone who has hacked in.
        // in other words, through the policy edit, and the value it returns, enable action to this post.
        return auth()->user()->can('edit', $this->post);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    // public function _no_rules(): string { // this simply means a string is the one expected from here
    //     return 'Hellp';
    // }

    public function rules(): array //and this means that an array is the one expected here
    {
        return [
            'body' => ['required']
        ];
    }
}
