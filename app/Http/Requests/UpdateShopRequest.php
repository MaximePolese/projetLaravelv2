<?php

namespace App\Http\Requests;

use App\Models\Shop;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UpdateShopRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $shop = $this->route('shop');
        return Auth::id() == $shop->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'shop_name' => ['nullable', 'string', 'max:255'],
            'shop_theme' => ['nullable', 'string', 'max:255'],
            'biography' => ['nullable', 'string', 'max:5000'],
        ];
    }

    protected function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }

    public function messages(): array
    {
        return [
            'shop_name.required' => 'Le nom de la boutique est obligatoire.',
            'shop_name.string' => 'Le nom de la boutique doit être une chaîne de caractères.',
            'shop_name.max' => 'Le nom de la boutique ne doit pas dépasser 255 caractères.',
            'shop_theme.string' => 'Le thème de la boutique doit être une chaîne de caractères.',
            'shop_theme.max' => 'Le thème de la boutique ne doit pas dépasser 255 caractères.',
            'biography.string' => 'La biographie doit être une chaîne de caractères.',
            'biography.max' => 'La biographie ne doit pas dépasser 5000 caractères.'
        ];
    }
}
