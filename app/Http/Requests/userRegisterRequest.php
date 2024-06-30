<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class userRegisterRequest extends FormRequest
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
            "name"=>"required",
            "email"=>"required|unique:users,email",
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
            "name.required"=>"le name est requis",
            "email.required"=>"l'email est reqis ",
            "email.unique"=>"l'email est existe déja",
            "password.required"=>"le mot de passe est requis"
        ];
    }
}
