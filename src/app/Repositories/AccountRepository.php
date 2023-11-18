<?php

namespace App\Repositories;

use App\Models\Account;
use Illuminate\Support\Facades\DB;

class AccountRepository
{
    public function createAccount($account_id)
    {
        try {
            return DB::transaction(function () use($account_id) {
                return Account::firstOrCreate(
                    ['conta_id' => $account_id],
                    ['saldo' => 500],
                );
            });
        } catch (\Exception $exception) {
            return response()->json(['errors' => ['message' => $exception->getMessage()]], $exception->getCode());
        }
    }

    public function find($account_id)
    {
        try {
            return DB::transaction(function () use($account_id) {
                return Account::where('conta_id', $account_id)->first();
            });
        } catch (\Exception $exception) {
            return response()->json(['errors' => ['message' => $exception->getMessage()]], $exception->getCode());
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
