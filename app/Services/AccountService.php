<?php

namespace App\Services;

use App\Repositories\AccountRepository;
use App\Interfaces\Services\IAccountService;

class AccountService
{
    protected $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function create(array $requestData)
    {
        $account = $this->accountRepository->store($requestData);

        return $account;
    }
}
