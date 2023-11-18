<?php

namespace App\Http\Controllers;

use App\Helpers\TransactionHelper;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Repositories\AccountRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * @var AccountRepository
     */
    private $accountRepository;
    private $transactionHelper;
    private $transactionRepository;

    public function __construct(AccountRepository $accountRepository,
                                TransactionHelper $transactionHelper,
                                TransactionRepository $transactionRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->transactionHelper = $transactionHelper;
        $this->transactionRepository = $transactionRepository;
    }

    public function transaction(TransactionRequest $request) {
        $payload = [
            "forma_pagamento" => $request->forma_pagamento,
            "conta_id" => $request->conta_id,
            "valor" => $request->valor,
        ];
        $account = $this->accountRepository->createAccount($payload['conta_id']);
        $calcResult = $this->transactionHelper->calcTransaction($account, $payload);
        if(is_array($calcResult)) {
            return response()->json($calcResult[0], $calcResult[1]);
        }
        $transaction = $this->transactionRepository->saveActualBalance($account, $calcResult);
        return new TransactionResource($transaction);
    }
}
