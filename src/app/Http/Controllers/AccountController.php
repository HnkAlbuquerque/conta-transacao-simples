<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Repositories\AccountRepository;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * @var AccountRepository
     */
    private $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function account(AccountRequest $request)
    {
        $arrayMessages = $this->accountRepository->returnAccountResponses($request->conta_id);
        return response()->json($arrayMessages[0], $arrayMessages[1]);
    }
}
