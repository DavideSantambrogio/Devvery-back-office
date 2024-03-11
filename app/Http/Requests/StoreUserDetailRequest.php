<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserDetailRequest extends FormRequest
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
            'vat_number' => ['required', 'string', 'min:6', 'max:20', 'unique:user_details'],
            'phone' => ['required', 'string', 'min:10','max:15', 'unique:user_details'],
            'address' => ['required', 'min:10']
        ];
    }

    public function messages(): array
    {
        return [
            // vat
            'vat_number.required' => 'Il campo Partita Iva è obbligatorio.',
            'vat_number.min' => 'Il campo Partita Iva è troppo corto.',
            'vat_number.max' => 'Il campo Partita Iva è troppo lungo.',
            'vat_number.unique' => 'Partita Iva già inserita.',

            // phone
            'phone.required' => 'Numero di telefono obbligatorio',
            'phone.string' => 'Numero di telefono non valido',
            'phone.min' => 'Numero di telefono troppo corto, minimo 10 cifre',
            'phone.max' => 'Numero di telefono troppo lungo, massimo 15 cifre',
            'phone.unique' => 'Numero di telefono già inserito',

            //address
            'address.required' => "Inserisci un'indirizzo",
            'address.min' => "Inserisci un'indirizzo valido"
        ];
    }
}
