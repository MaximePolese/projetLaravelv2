<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::id() == $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pseudo' => ['nullable', 'string', 'max:255'],
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'string', 'max:5000'],
            'delivery_address' => ['nullable', 'string', 'max:255'],
        ];
    }

    protected function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }

    public function messages(): array
    {
        return [
            'pseudo.string' => 'Le pseudo doit être une chaîne de caractères.',
            'pseudo.max' => 'Le pseudo ne doit pas dépasser 255 caractères.',
            'first_name.required' => 'Le prénom est obligatoire.',
            'first_name.string' => 'Le prénom doit être une chaîne de caractères.',
            'first_name.max' => 'Le prénom ne doit pas dépasser 255 caractères.',
            'last_name.required' => 'Le nom de famille est obligatoire.',
            'last_name.string' => 'Le nom de famille doit être une chaîne de caractères.',
            'last_name.max' => 'Le nom de famille ne doit pas dépasser 255 caractères.',
            'email.required' => 'L\'email est obligatoire.',
            'email.string' => 'L\'email doit être une chaîne de caractères.',
            'email.lowercase' => 'L\'email doit être en minuscules.',
            'email.email' => 'L\'email doit être une adresse email valide.',
            'email.max' => 'L\'email ne doit pas dépasser 255 caractères.',
            'email.unique' => 'L\'email doit être unique.',
            'address.string' => 'L\'adresse doit être une chaîne de caractères.',
            'address.max' => 'L\'adresse ne doit pas dépasser 255 caractères.',
            'phone_number.string' => 'Le numéro de téléphone doit être une chaîne de caractères.',
            'phone_number.max' => 'Le numéro de téléphone ne doit pas dépasser 255 caractères.',
            'image.string' => 'L\'image doit être une chaîne de caractères.',
            'image.max' => 'L\'image ne doit pas dépasser 255 caractères.',
            'delivery_address.string' => 'L\'adresse de livraison doit être une chaîne de caractères.',
            'delivery_address.max' => 'L\'adresse de livraison ne doit pas dépasser 255 caractères.',
        ];
    }
}

