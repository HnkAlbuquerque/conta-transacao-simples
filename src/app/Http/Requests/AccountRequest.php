<?php

namespace App\Http\Requests;

class AccountRequest extends FormRequest
{
    protected $redirect = false;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function all($keys = null)
    {
        return array_replace_recursive(
            parent::all(),
            $this->route()->parameters()
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'conta_id' => 'required|numeric|min:1|max:9999'
        ];
    }

    public function messages()
    {
        return[
            'conta_id.required' => 'Deve informar uma conta para prosseguir',
            'conta_id.numeric' => 'A conta deve ser um número',
            'conta_id.min' => 'Deve ser maior que 0',
            'conta_id.max' => 'Deve ser menor que 10000',
        ];
    }


}
