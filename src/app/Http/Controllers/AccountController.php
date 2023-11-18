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

    /**
     * @OA\Get(
     *     path="/api/conta/{conta_id}",
     *     summary="Get logged-in user details",
     *     @OA\Parameter(
     *          name="conta_id",
     *          in="query",
     *          description="Id da conta",
     *          required=true,
     *          @OA\Schema(type="numeric")
     *      ),
     *     @OA\Response(response="200", description="Retorna conta descrita"),
     *     @OA\Response(response="404", description="Conta inexistente, not found")
     * )
     */
    public function account(AccountRequest $request)
    {
        $arrayMessages = $this->accountRepository->returnAccountResponses($request->conta_id);
        return response()->json($arrayMessages[0], $arrayMessages[1]);
    }
}
