<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDealRequest extends FormRequest
{
    public function rules(): array
    {
        return [
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
