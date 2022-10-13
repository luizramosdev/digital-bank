<?php

namespace App\Repositories;

use App\Interfaces\Repositories\IAccountRepository;
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
}
