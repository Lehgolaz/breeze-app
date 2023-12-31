<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            //
            'titulo' => 'required|string|min:3|max:240',
            'conteudo' => 'required|string|min:3|max:6000',
            'imagem_destaque' => 'image|max:1024|mimes:jpg,jpeg,png',
        ];
    }
}