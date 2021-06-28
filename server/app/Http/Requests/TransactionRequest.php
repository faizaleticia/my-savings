<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class TransactionRequest extends FormRequest
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
        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                    return [];
                }
            case 'POST': {
                    return [
                        'value'               => 'required',
                        'transaction_type_id' => 'required',
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'value'               => 'required',
                        'transaction_type_id' => 'required',
                    ];
                }
            default:
                break;
        }
    }

    public function messages()
    {
        return [
            'value.required'               => 'O campo valor é obrigatório',
            'transaction_type_id.required' => 'O campo tipo de transação é obrigatório',
        ];
    }

    public function response(array $errors)
    {
        return Response::create($errors, 403);
    }
}
