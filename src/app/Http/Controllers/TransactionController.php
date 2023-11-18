<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Repositories\AccountRepository;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * @var AccountRepository
     */
    private $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function transaction(TransactionRequest $request) {
        return 'ok';
    }
}
