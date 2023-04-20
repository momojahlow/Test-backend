<?php

namespace App\Http\Requests;

use App\Models\Societe;
use Illuminate\Foundation\Http\FormRequest;

class StoreSocieteRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'adresse' => ['required', 'string', 'max:255'],
            'ville' => ['required', 'string', 'max:255'],
            'raison_sociale' => ['required', 'string', 'max:255', 'unique:'.Societe::class],
            'ice' => ['required', 'string', 'max:255', 'unique:'.Societe::class],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.Societe::class],
            'telephone' => ['required', 'string', 'max:255', 'unique:'.Societe::class],
        ];
    }
}
