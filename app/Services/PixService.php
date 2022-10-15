<?php

namespace App\Services;

use App\Models\Pix;
use App\Models\Account;
use Illuminate\Support\Str;
use App\Services\AccountService;
use App\Repositories\PixRepository;

class PixService
{
    protected $pixRepository;
    protected $accountService;
    protected $userService;

    public function __construct(PixRepository $pixRepository, AccountService $accountService, UserService $userService)
    {
        $this->pixRepository = $pixRepository;
        $this->accountService = $accountService;
        $this->userService = $userService;
    }

    public function create(array $requestData)
    {
        $account = $this->accountService->getAccountByAuth();

        $accountId = $this->findByAccountId($account->id);
        if($accountId) throw new \Exception('this account already has a registered key', 404);

        $activeAccount = $this->accountService->checkActiveAccounts($account);
        if(!$activeAccount) throw new \Exception('account must be active', 404);

        switch($requestData['type_key'])
        {
            case 'CPF':
                $this->documentKey($account, $requestData);
            break;
            case 'CNPJ':
                $this->documentKey($account, $requestData);
            break;
        }

        $requestData['uuid'] = Str::uuid(10);
        $requestData['account_id'] = $account->id;

        $pix = $this->pixRepository->store($requestData);

        return $pix;

    }

    public function documentKey(Account $account, array $requestData)
    {
        $document = $this->userService->findUserByDocument($requestData['pix_key']);

        if(!$document) throw new \Exception('document not found', 404);

        return $document;
    }

    public function findByPixKey(string $key)
    {
        $pix = $this->pixRepository->findByPixKey($key);

        return $pix;
    }

    public function findByAccountId(int $account_id)
    {
        $pix = $this->pixRepository->findByAccountId($account_id);

        return $pix;
    }
}
