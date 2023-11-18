<?php

namespace App\Helpers;

class TransactionHelper
{
    public function calcTransaction($account, $payload)
    {
        switch($payload['forma_pagamento']) {
            case 'P':
                $sum = $account->saldo - $payload['valor'];
                break;
            case 'C':
                $sum = $account->saldo - ($payload['valor'] + ($payload['valor'] * 0.05));
                break;
            case 'D':
                $sum = $account->saldo - ($payload['valor'] + ($payload['valor'] * 0.03));
                break;
        }

        if($sum < 0) {
            $response[0] = [
                'errors' => [
                    "message" => "Fundos insuficientes, realize um deposito antes de fazer esta operacao",
                ],
            ];
            $response[1] = 400;
            return $response;
        }
        return $sum;
    }
}
