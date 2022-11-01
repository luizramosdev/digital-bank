<?php

namespace App\Repositories;

use App\Models\Account;

class AccountRepository
{
    protected $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function store(array $requestData)
    {
        $account = $this->account->create($requestData);

        return $account;
    }

    public function findAccountById(int $account_id)
    {
        $account = $this->account->where('id', $account_id)->first();

        return $account;
    }

    public function getByAccountNumber(string $accountNumber)
    {
        $account = $this->account->where('account_number', $accountNumber)->first();

        return $account;
    }

    public function inactivate(Account $account, string $status)
    {
        $account->status = $status;
        $account->save();

        return $account;
    }

    public function activate(Account $account, string $status)
    {

        $account->status = $status;
        $account->save();

        return $account;
    }

    public function addBalance(Account $account, $amount)
    {
        $account->balance += $amount;
        $account->save();

        return $account;
    }

    public function balanceExit(Account $account, $amount)
    {
        $account->balance -= $amount;
        $account->save();

        return $account;
    }
}
