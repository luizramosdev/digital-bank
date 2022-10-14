<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Services\AccountService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function show()
    {
        try {
            $account = $this->accountService->getAccountByAuth();

            if(!$account) throw new \Exception('account not found', 404);

            return $account;
        } catch (\Exception $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ], $e->getCode());
        }

    }
}
