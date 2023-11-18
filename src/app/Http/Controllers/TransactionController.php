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

    /**
     * @OA\Post(
     *     path="/api/transacao",
     *     summary="Efetua uma nova transação",
     *     @OA\Parameter(
     *         name="forma_pagamento",
     *         in="query",
     *         description="Forma de pagamento, pix, crédito, débito",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="conta_id",
     *         in="query",
     *         description="Id da conta",
     *         required=true,
     *         @OA\Schema(type="numeric")
     *     ),
     *     @OA\Parameter(
     *         name="valor",
     *         in="query",
     *         description="Valor da transação",
     *         required=true,
     *         @OA\Schema(type="numeric")
     *     ),
     *     @OA\Response(response="200", description="Transação efetuada com sucesso"),
     *     @OA\Response(response="422", description="Erros de Validação")
     * )
     */
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
