<?php

namespace Tests\Feature\app\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountControllerTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    public function testRetrieveAccount()
    {
        $this->createAccount(['conta_id' => '1234']);
        $response = $this->get(route('conta', ['1234']));
        $response->assertStatus(200);
        $response->assertJson([
            "conta_id" => "1234",
            "saldo" => 500,
        ], 200);
    }

    public function testAccountNotFound()
    {
        $response = $this->get(route('conta',['8796']));
        $response->assertStatus(404);
        $response->assertJson([
            'errors' => [
                "message" => "Conta nao encontrada",
            ],
        ], 404);
    }
}
