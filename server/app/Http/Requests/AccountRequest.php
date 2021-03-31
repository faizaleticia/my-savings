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
                        'letter'      => 'required|string',
                        'name'        => 'required|string',
                        'description' => 'required|string',
                        'color'       => 'required|string',
                    ];
                }
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'letter'      => 'required|string',
                        'name'        => 'required|string',
                        'description' => 'required|string',
                        'color'       => 'required|string',
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'letter.required'      => 'O campo letra é obrigatório',
            'name.required'        => 'O campo nome é obrigatório',
            'description.required' => 'O campo descrição é obrigatório',
            'color.required'       => 'O campo cor é obrigatório',
        ];
    }

    public function response(array $errors) {
        return Response::create($errors, 403);
    }
}
