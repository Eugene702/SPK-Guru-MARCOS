<?php

namespace App\Http\Requests\Admin\DataGuru;

use Illuminate\Foundation\Http\FormRequest;

class ImportRequest extends FormRequest
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
            'document' => ['required','file','mimes:xlsx', 'size:10240']
        ];
    }

    public function messages(){
        return [
            'document.required' => 'File tidak boleh kosong',
            'document.file' => 'File harus berupa file',
            'document.mimes' => 'File harus berupa file dengan format xlsx',
            'document.size' => 'Ukuran file tidak boleh lebih dari 10 MB',
        ];
    }
}
