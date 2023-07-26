<?php

namespace App\Http\Requests;

use App\Models\Document;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDocumentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('document_edit');
    }

    public function rules()
    {
        return [
            'title'                 => [
                'string',
                'required',
            ],
            'policy_number'         => [
                'string',
                'nullable',
            ],
            'policy_owner'          => [
                'string',
                'required',
            ],
            'start_date'            => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'end_date'              => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'maturity_date'         => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'premium_payment_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'policy_purchased_from' => [
                'string',
                'nullable',
            ]
        ];
    }
}
