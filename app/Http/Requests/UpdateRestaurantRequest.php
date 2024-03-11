<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRestaurantRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:2', 'max:50', Rule::unique('restaurants')->ignore($this->restaurant)],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric', 'min:9', 'max:15', Rule::unique('restaurants')->ignore($this->restaurant)],
            'cover_image' => ['nullable', 'image','mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
            'phone' => ['required', 'string', 'min:9', 'max:15', Rule::unique('restaurants')->ignore($this->restaurant)],
            'cover_image' => ['nullable', 'image', 'max:4096'],
            'user_id' => ['nullable', 'numeric', 'exists:users,id'],
            'description' => ['nullable', 'string', 'max:255']
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
            'name.min' => 'Il campo nome deve contenere almeno :min caratteri.',
            'name.max' => 'Il campo nome non può superare :max caratteri.',
            'name.unique' => 'Il nome inserito è già utilizzato da un altro ristorante.',

            // address
            'address.required' => 'Il campo indirizzo è obbligatorio.',
            'address.max' => 'Il campo indirizzo non può superare :max caratteri.',

            // phone
            'phone.required' => 'Il campo telefono è obbligatorio.',
            'phone.numeric' => 'Il campo telefono non deve contenere lettere.',
            'phone.min' => 'Il campo telefono deve contenere almeno :min cifre.',
            'phone.max' => 'Il campo telefono non può superare :max cifre.',
            'phone.unique' => 'Il numero di telefono inserito è già utilizzato da un altro ristorante.',

            // image
            'cover_image.image' => 'Il file deve essere un immagine.',
            'cover_image.max' => 'Il file non è troppo pesante.',
            'cover_image.mimes' => 'Il file deve essere di tipo: :values.',

            'description.max' => 'La descrizione non può superare :max caratteri.'
        ];
    }
}
