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

    public function show($account_id)
    {
        try {
            $account = $this->accountService->findAccountById($account_id);

            if(!$account) throw new \Exception('account not found', 404);

            return response()->json([
                'code' => 200,
                'data' => $account
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function accountAuth()
    {
        try {
            $account = $this->accountService->getAccountByAuth();

            if(!$account) throw new \Exception('account not found', 404);

            return response()->json([
                'code' => 200,
                'data' => $account
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function inactivate()
    {
        try {
            $account = $this->accountService->inactivate();

            return response()->json([
                'code' => 200,
                'data' => $account
            ], 200);
        } catch(\Exception $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function activate()
    {
        try {
            $account = $this->accountService->activate();

            return response()->json([
                'code' => 200,
                'data' => $account
            ], 200);
        } catch(\Exception $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }
}
