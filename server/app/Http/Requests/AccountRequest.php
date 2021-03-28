<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class AccountRequest extends FormRequest
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
            case 'DELETE':
                {
                    return [];
                }
            case 'POST':
                {
                    return [
                        'name'        => 'required|string',
                        'description' => 'required|string',
                    ];
                }
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'name'        => 'required|string',
                        'description' => 'required|string',
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'name.required'        => 'O campo nome é obrigatório',
            'description.required' => 'O campo descrição é obrigatório',
        ];
    }

    public function response(array $errors) {
        return Response::create($errors, 403);
    }
}
