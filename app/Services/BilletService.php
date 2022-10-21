<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Services\AccountService;
use App\Repositories\BilletRepository;
use DateTime;
use DateTimeZone;

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

        $timeZone = new DateTimeZone('America/Sao_Paulo');
        $now = date('Y-m-d');
        $due_date = $requestData['due_date'];

        $now = DateTime::createFromFormat('Y-m-d', $now, $timeZone);
        $due_date = DateTime::createFromFormat('Y-m-d', $due_date, $timeZone);

        if($due_date < $now) throw new \Exception('due date entered has passed', 404);

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

    public function findBilletByBarCode(string $bar_code)
    {
        $billet = $this->billetRepository->findBilletByBarCode($bar_code);

        if(!$billet) throw new \Exception('billet not found', 404);

        return $billet;
    }

    public function myGeneratedBillets()
    {
        $account = $this->accountService->getAccountByAuth();

        $billets = $this->billetRepository->findBilletByAccountId($account->id);

        if($billets->count() === 0) throw new \Exception('dont have a billet generated', 404);

        return $billets;
    }

    public function myBilletsToPay()
    {
        $user = $this->userService->getUserByAuth();

        $billets = $this->billetRepository->findBilletByDocument($user->document);

        if($billets->count() === 0) throw new \Exception('dont have a billet to pay', 404);

        return $billets;
    }
}
