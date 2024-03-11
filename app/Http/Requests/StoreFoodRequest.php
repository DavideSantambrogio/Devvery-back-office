<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFoodRequest extends FormRequest
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
            'name' => 'required|string|max:30',
            'price' => 'required|numeric|not_in:0',
            'description' => 'nullable|string|max:255',
            'vegan' => 'nullable|boolean',
            'celiac' => 'nullable|boolean',
            'available' => 'nullable|boolean',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'category_id' => 'required|numeric'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // name
            'name.required' => 'Il campo nome è obbligatorio.',
            'name.string' => 'Il campo nome deve essere una stringa.',
            'name.max' => 'La nome non può superare :max caratteri.',

            // price
            'price.required' => 'Il campo prezzo è obbligatorio.',            
            'price.not_in' => 'Il prezzo non può essere uguale a 0.',
            'price.numeric' => 'Il campo prezzo deve essere un numero.',

            // description,
            'description.max' => 'La descrizione non può superare :max caratteri.',

            // image
            'cover_image.image' => "Il file deve essere un'immagine.",
            'cover_image.mimes' => 'Il file deve essere di tipo: :values.',
            'cover_image.max' => 'Il file è troppo pesante.',

            // category
            'category_id' => 'Seleziona una categoria'

        ];
    }

    
}
