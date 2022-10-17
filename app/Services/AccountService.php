<?php

namespace App\Services;

use App\Repositories\AccountRepository;
use App\Models\Account;

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

    public function getAccountByAuth()
    {
        $account = auth()->user()->account;

        return $account;
    }

    public function findAccountById(int $account_id)
    {
        $account = $this->accountRepository->findAccountById($account_id);

        return $account;
    }

    public function getByAccountNumber(string $accountNumber)
    {
        $account = $this->accountRepository->getByAccountNumber($accountNumber);

        return $account;
    }

    public function checkActiveAccounts (Account $account)
    {
        if(!$account->status == 'ACTIVE')
        {
            return false;
        }

        return true;
    }

    public function checkBalance(float $balance, float $amount)
    {
        if($balance < $amount){
            return true;
        } else {
            return false;
        }
    }
}
