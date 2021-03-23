<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class ContactRequest extends FormRequest
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
                        'name'      => 'required|string',
                        'email'     => 'required|unique:contacts,email',
                        'phone'     => 'required',
                        'birthDate' => 'required',
                    ];
                }
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'name'      => 'required|string',
                        'email'     => 'required|unique:contacts,email,' . $this->get('id'),
                        'phone'     => 'required',
                        'birthDate' => 'required',
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'name.required'      => 'O campo nome é obrigatório',
            'email.required'     => 'O campo e-mail é obrigatório',
            'email.unique'       => 'O e-mail já está sendo utilizado por outro contato.',
            'phone.required'     => 'O campo telefone é obrigatório',
            'birthDate.required' => 'O campo data de nascimento é obrigatório',
        ];
    }

    public function response(array $errors) {
        return Response::create($errors, 403);
    }
}
