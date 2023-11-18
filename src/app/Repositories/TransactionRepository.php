<?php

namespace App\Repositories;

use App\Models\Account;
use Illuminate\Support\Facades\DB;

class TransactionRepository
{
    public function saveActualBalance($account, $sum)
    {
        try {
            return DB::transaction(function () use($account, $sum) {
                Account::where('conta_id', $account->conta_id)->update(['saldo' => $sum]);
                return Account::find($account->conta_id)->first();
            });
        } catch (\Exception $exception) {
            return response()->json(['errors' => ['message' => $exception->getMessage()]], $exception->getCode());
        }
    }
}
