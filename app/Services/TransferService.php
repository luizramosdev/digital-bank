<?php

namespace App\Services;

use App\Models\Account;
use Illuminate\Support\Str;
use App\Services\AccountService;
use App\Repositories\TransferRepository;

class TransferService
{
    protected $transferRepository;
    protected $accountService;

    public function __construct(TransferRepository $transferRepository, AccountService $accountService)
    {
        $this->transferRepository = $transferRepository;
        $this->accountService = $accountService;
    }

    public function create(array $requestData)
    {
        $transfer = $this->transferRepository->store($requestData);

        return $transfer;
    }

    public function transfer(array $requestData)
    {
        $from_account = auth()->user()->account;

        $to_account = $this->accountService->getByAccountNumber($requestData['to_account']);

        if(!$to_account) throw new \Exception('account not found', 404);

        $activeFromAccount = $this->accountService->checkActiveAccounts($from_account);
        if(!$activeFromAccount) throw new \Exception('from account must be active', 404);

        $activeToAccount = $this->accountService->checkActiveAccounts($to_account);
        if(!$activeToAccount) throw new \Exception('to account must be active', 404);

        switch($requestData['type_transfer'])
        {
            case 'TED':
            $transfer = $this->ted($from_account, $to_account, $requestData);
            break;
            case 'PIX':
            $transfer = $this->pix($from_account, $to_account, $requestData);
            break;
        }

        return $transfer;
    }

    public function ted(Account $from_account, Account $to_account, array $requestData)
    {
        $fee = 9.40;
        $amount = $requestData['amount'];
        $total = $amount + $fee;

        $enoughBalance = $this->accountService->checkBalance($from_account->balance, $total);

        if($enoughBalance) throw new \Exception('insufficient funds', 404);

        $requestData = [
            'uuid' => Str::uuid(10),
            'from_account' => $from_account->account_number,
            'to_account' => $to_account->account_number,
            'amount' => $amount,
            'fee' => $fee,
            'transfer_type' => 'TED'
        ];

        $transfer = $this->create($requestData);

        $from_account->balance -= $total;
        $from_account->save();

        $to_account->balance += $amount;
        $to_account->save();

        return $transfer;
    }

    public function pix(Account $from_account, Account $to_account, array $requestData)
    {

    }
}
