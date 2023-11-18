<?php

namespace App\Repositories;

use App\Models\Account;

class AccountRepository
{
    public function createAccount($params): Model
    {
        return Account::factory()->create($params);
    }

    public function find($account_id)
    {
        try {
            return Account::where('conta_id', $account_id)->first();
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    public function returnAccountResponses($account_id)
    {
        $account = $this->find($account_id);
        $response[0] = ['errors' => ['message' => 'Conta nao encontrada']];
        $response[1] = 404;
        if ($account) {
            $response[0] = ['conta_id' => $account->conta_id, 'saldo' => $account->saldo];
            $response[1] = 200;
        }
        return $response;
    }

}
