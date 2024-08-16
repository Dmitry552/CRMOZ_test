<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccountRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'account' => [
                'required',
                'array',
                'min:1'
            ],
            'account.Account_Name' => [
                'required',
                'string'
            ],
            'account.Website' => [
                'url'
            ],
            'account.Phone' => [
                'string',
                'max:30'
            ],
        ];
    }
}
