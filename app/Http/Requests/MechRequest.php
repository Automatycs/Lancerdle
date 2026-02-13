<?php

namespace App\Http\Requests;

use App\Enums\MechsPool;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class MechRequest extends FormRequest
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
			'pool' => ['required', new Enum(MechsPool::class)],
			'lcp' => 'required|string|max:255',
			'name' => 'required|string|max:255',
			'manufacturer' => 'required|string|max:255',
			'hp' => 'required|integer|min:0',
			'heat_cap' => 'required|integer|min:0',
			'armor' => 'required|integer|min:0',
			'evasion' => 'required|integer|min:0',
			'e_defense' => 'required|integer|min:0',
			'sensors' => 'required|integer|min:0',
			'tech_attack' => 'required|integer',
			'repair_capacity' => 'required|integer|min:0',
			'save_target' => 'required|integer|min:0',
			'speed' => 'required|integer|min:0',
			'system_points' => 'required|integer|min:0',
			'mounts' => 'required|string',
        ];
    }

}
