<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
//        $productId = $this->route('product');
//        $product = Product::find($productId);
//        return Auth::id() == $product->shop->user_id;
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
            'product_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'story' => ['nullable', 'string', 'max:5000'],
            'image' => ['nullable', 'string', 'max:255'],
            'material' => ['nullable', 'string', 'max:255'],
            'color' => ['nullable', 'string', 'max:255'],
            'size' => ['nullable', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'updated_at' => ['date'],
        ];
    }

    protected function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }

    public function messages(): array
    {
        return [
            'product_name.required' => 'Le nom du produit est obligatoire.',
            'product_name.string' => 'Le nom du produit doit être une chaîne de caractères.',
            'product_name.max' => 'Le nom du produit ne doit pas dépasser 255 caractères.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            'description.max' => 'La description ne doit pas dépasser 5000 caractères.',
            'story.string' => 'L\'histoire doit être une chaîne de caractères.',
            'story.max' => 'L\'histoire ne doit pas dépasser 5000 caractères.',
            'image.string' => 'L\'image doit être une chaîne de caractères.',
            'image.max' => 'L\'image ne doit pas dépasser 255 caractères.',
            'material.string' => 'Le matériau doit être une chaîne de caractères.',
            'material.max' => 'Le matériau ne doit pas dépasser 255 caractères.',
            'color.string' => 'La couleur doit être une chaîne de caractères.',
            'color.max' => 'La couleur ne doit pas dépasser 255 caractères.',
            'size.string' => 'La taille doit être une chaîne de caractères.',
            'size.max' => 'La taille ne doit pas dépasser 255 caractères.',
            'category.required' => 'La catégorie est obligatoire.',
            'category.string' => 'La catégorie doit être une chaîne de caractères.',
            'category.max' => 'La catégorie ne doit pas dépasser 255 caractères.',
            'price.required' => 'Le prix est obligatoire.',
            'price.numeric' => 'Le prix doit être un nombre.',
            'price.min' => 'Le prix ne doit pas être inférieur à 0.',
            'stock_quantity.required' => 'La quantité en stock est obligatoire.',
            'stock_quantity.integer' => 'La quantité en stock doit être un entier.',
            'stock_quantity.min' => 'La quantité en stock ne doit pas être inférieure à 0.',
            'updated_at.date' => 'La date de mise à jour doit être une date valide.',
        ];
    }
}
