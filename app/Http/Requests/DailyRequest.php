<?php

namespace App\Http\Requests;

use App\Enums\MechsPool;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class DailyRequest extends FormRequest
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
            'date' => ['date', 'required', Rule::date()->format('Y-m-d')],
			'pool' => ['required', new Enum(MechsPool::class)],
			'mech_id' => ['required', 'exists:mechs,id'],
        ];
    }
}
