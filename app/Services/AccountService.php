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
        if($account->status !== 'ACTIVE')
        {
            throw new \Exception('account is not active', 404);
        }

        return false;
    }

    public function checkBalance(float $balance, float $amount)
    {
        if($balance < $amount){
            throw new \Exception('insufficient funds', 404);
        } else {
            return false;
        }
    }

    public function inactivate()
    {
        $account = $this->getAccountByAuth();

        if(!$account->status === 'ACTIVATE') throw new \Exception('the account must be active to deactivate it', 404);

        if($account->balance !== 0.00) throw new \Exception('to deactivate the account the balance must be 0.00', 404);

        $status = 'INACTIVE';

        $account = $this->accountRepository->inactivate($account, $status);

        return $account;
    }

    public function activate()
    {
        $account = $this->getAccountByAuth();

        if(!$account->status === 'INACTIVE') throw new \Exception('the account must be inactive to activate it', 404);

        $status = 'ACTIVE';

        $account = $this->accountRepository->activate($account, $status);

        return $account;
    }

    public function addBalance(Account $account, $amount)
    {
        $account = $this->accountRepository->addBalance($account, $amount);

        return $account;
    }

    public function balanceExit(Account $account, $amount)
    {
        $account = $this->accountRepository->balanceExit($account, $amount);

        return $account;
    }
}
