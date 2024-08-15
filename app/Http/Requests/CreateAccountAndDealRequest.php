<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccountAndDealRequest extends FormRequest
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
            'deal' => [
                'required',
                'array',
                'min:1'
            ],
            'deal.Deal_Name' => [
                'required',
                'string'
            ],
            'deal.Stage' => [
                'required',
                'string'
            ]
        ];
    }
}
