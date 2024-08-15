<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetRequiredFieldsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'fields' => [
                'string',
                'nullable'
            ]
        ];
    }
}
