<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'amount' => ['required', 'integer', 'min:1000', 'max:50000000'],
            'source_card_number' => ['required', 'exists:cards,card_number','different:destination_card_number'],
            'destination_card_number' => ['required', 'exists:cards,card_number'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'source_card_number' => to_english_numbers($this->input('source_card_number')),
            'destination_card_number' => to_english_numbers($this->input('destination_card_number'))
        ]);
    }
}
