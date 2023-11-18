<?php

namespace Tests\Feature\app\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    //Implementando 3 testes padrões do desafio
    public function testDebitOperation()
    {
        $payload = [
            'forma_pagamento' => 'D',
            'conta_id' => '3333',
            'valor' => 50
        ];
        $this->createAccount(['conta_id' => '3333']);
        $response = $this->post(route('transacao'), $payload, );
        $response->assertStatus(200);
        $response->assertJson(['saldo' => 448.50],
         200);
        $this->assertDatabaseHas('account',[
            'conta_id' => '3333',
            'saldo' => 448.50
        ]);
    }

    public function testCreditOperation()
    {
        $payload = [
            'forma_pagamento' => 'C',
            'conta_id' => '4444',
            'valor' => 100
        ];
        $this->createAccount(['conta_id' => '4444']);
        $response = $this->post(route('transacao'), $payload, );
        $response->assertStatus(200);
        $response->assertJson(['saldo' => 395.00],
            200);
        $this->assertDatabaseHas('account',[
            'conta_id' => '4444',
            'saldo' => 395.00
        ]);
    }

    public function testPixOperation()
    {
        $payload = [
            'forma_pagamento' => 'P',
            'conta_id' => '5555',
            'valor' => 75
        ];
        $this->createAccount(['conta_id' => '5555']);
        $response = $this->post(route('transacao'), $payload, );
        $response->assertStatus(200);
        $response->assertJson(['saldo' => 425.00],
            200);
        $this->assertDatabaseHas('account',[
            'conta_id' => 5555,
            'saldo' => 425.00
        ]);
    }

    // implementando testes adicionais
    public function testSendingNonExistentAccountShouldCreateAtTransactionRoute()
    {
        $payload = [
            'forma_pagamento' => 'P',
            'conta_id' => '9999',
            'valor' => 9.00
        ];
        $response = $this->post(route('transacao'), $payload, );
        $response->assertStatus(200);
        $response->assertJson(['saldo' => 491.00],
            200);
        $this->assertDatabaseHas('account',[
            'conta_id' => 555,
            'saldo' => 491.00
        ]);
    }

    public function testNonExistentOperationLetter()
    {
        $payload = [
            'forma_pagamento' => 'F',
            'conta_id' => '1001',
            'valor' => -500
        ];
        $response = $this->post(route('transacao'), $payload, );
        $response->assertStatus(422);
        $response->assertJson([
            'errors' => [
                "forma_pagemnto" => ["Forma de pagamento deve seguir a seguinte regra: P = Pix | D = Débito | C = Crédito"],
            ],
        ], 422);
    }

    public function testBalance()
    {
        $payload = [
            'forma_pagamento' => 'C',
            'conta_id' => '1001',
            'valor' => 550
        ];
        $this->createAccount(['conta_id' => '1001']);
        $response = $this->post(route('transacao'), $payload, );
        $response->assertStatus(400);
        $response->assertJson([
            'errors' => [
                "message" => [ "Fundos insuficientes, realize um depósito antes de fazer esta operação"],
            ],
        ], 400);
    }

    public function testNegativeRequest()
    {
        $payload = [
            'forma_pagamento' => 'C',
            'conta_id' => '1001',
            'valor' => -500
        ];
        $response = $this->post(route('transacao'), $payload, );
        $response->assertStatus(422);
        $response->assertJson([
            'errors' => [
                "valor" => ["Não é possível realizar uma transferencia com valor negativo"],
            ],
        ], 422);
    }

    public function testValidateAccountRequest()
    {
        $payload = [
            'forma_pagamento' => 'C',
            'conta_id' => 'FAKE-ACC',
            'valor' => -500
        ];
        $response = $this->post(route('transacao'), $payload, );
        $response->assertStatus(422);
        $response->assertJson([
            'errors' => [
                "conta_id" => ["Id da conta deve ser uma string numérica de até 4 digitos"],
            ],
        ], 422);
    }

    public function testRetrieveAccount()
    {
        $this->createAccount(['conta_id' => '1234']);
        $response = $this->get(route('conta', ['1234']));
        $response->assertStatus(200);
        $response->assertJson([
                "conta_id" => "1234",
                "saldo" => 500.00,
        ], 200);
    }

    public function testAccountNotFound()
    {
        $response = $this->get(route('conta',['8796']));
        $response->assertStatus(404);
        $response->assertJson([
            'errors' => [
                "message" => [ "Conta não encontrada"],
            ],
        ], 404);
    }
}
