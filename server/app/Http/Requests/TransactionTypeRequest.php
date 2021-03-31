<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class TransactionTypeRequest extends FormRequest
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
                        'code'      => 'required',
                        'name'      => 'required|string',
                        'operation' => 'required',
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'code'      => 'required',
                        'name'      => 'required|string',
                        'operation' => 'required',
                    ];
                }
            default:
                break;
        }
    }

    public function messages()
    {
        return [
            'code.required'      => 'O campo código é obrigatório',
            'name.required'      => 'O campo nome é obrigatório',
            'operation.required' => 'O campo operação é obrigatório',
        ];
    }

    public function response(array $errors)
    {
        return Response::create($errors, 403);
    }
}
