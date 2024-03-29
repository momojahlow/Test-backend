<?php

namespace App\Http\Requests;

use App\Models\Invit;
use Illuminate\Foundation\Http\FormRequest;

class StoreInvitRequest extends FormRequest
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
            'societe_id' => ['required'],
            'token' => ['nullable', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.Invit::class],
        ];
    }
}
