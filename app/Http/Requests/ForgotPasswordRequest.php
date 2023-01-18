<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ForgotPasswordRequest extends FormRequest
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
            'email' => 'required|email|exists:users'
        ];
    }

    /**
     * the data of above request
     *
     * @return void
     */
    public function data()
    {
        return [
            'email' => request()->email,
            'code' => Str::random(6),
            'created_at' => now()
        ];
    }
}
