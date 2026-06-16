<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBeritaRequest extends FormRequest
{
    /**
     * Request tidak dipakai (validasi inline di controller)
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Aturan validasi (tidak diimplementasikan)
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
