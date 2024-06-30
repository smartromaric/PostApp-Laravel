<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class logUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "email"=>"required|email|exists:users,email",
            "password"=>"required"
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json(
            [
                "success"=>false,
                "status_code"=>422,
                "error"=>true,
                "message"=>"erreur de validation",
                "error list"=>$validator->errors(),
            ]
            ));
    }
    public function messages(){
        return [
            "email.required"=>"le champ email est obligatoire",
            "email.email"=>"le champ email doit être un email valide",
            "email.exists"=>"l'email saisie n'existe pas",
            "password.required"=>"le champ mot de passe est obligatoire",
        ];
    }
}
