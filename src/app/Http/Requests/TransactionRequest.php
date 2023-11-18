<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class TransactionRequest extends FormRequest
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
            'forma_pagamento' => ['required', Rule::in(['P', 'C', 'D'])],
            'conta_id' => 'required|numeric|min:1|max:9999',
            'valor' => 'required|numeric|min:1'
        ];
    }

    public function messages()
    {
        return[
            'forma_pagamento.required' => 'Forma de pagamento é requerida',
            'forma_pagamento.in' => 'Forma de pagamento deve seguir a seguinte regra: P = Pix | D = Debito | C = Credito',
            'conta_id.required' => 'Deve informar uma conta para prosseguir',
            'conta_id.numeric' => 'Id da conta deve ser uma string numérica de até 4 digitos',
            'conta_id.min' => 'Deve ser maior que 0',
            'conta_id.max' => 'Deve ser menor que 10000',
            'valor.required' => 'Valor é requerido',
            'valor.numeric' => 'Deve ser um número',
            'valor.min' => 'Não é possível realizar uma transferencia com valor menor que 1',
        ];
    }
}
