<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Services\AccountService;
use App\Repositories\BilletRepository;

class BilletService
{
    protected $billetRepository;
    protected $accountService;
    protected $userService;

    public function __construct(BilletRepository $billetRepository, AccountService $accountService, UserService $userService)
    {
        $this->billetRepository = $billetRepository;
        $this->accountService = $accountService;
        $this->userService = $userService;
    }

    public function create(array $requestData)
    {
        $from_account = $this->accountService->getAccountByAuth();

        $activeFromAccount = $this->accountService->checkActiveAccounts($from_account);
        if(!$activeFromAccount) throw new \Exception('your account must be active');

        $payer = $this->userService->findUserByDocument($requestData['payer_document']);
        if(!$payer) throw new \Exception('payer not found', 404);

        $data = [
            'uuid' => Str::uuid(10),
            'account_id' => $from_account->id,
            'bar_code' => rand(9, 9999999999),
            'amount' => $requestData['amount'],
            'due_date' => $requestData['due_date'],
            'payer_document' => $requestData['payer_document']
        ];

        $billet = $this->billetRepository->store($data);

        return $billet;
    }
}
