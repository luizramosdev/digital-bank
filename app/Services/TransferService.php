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
    protected $pixService;

    public function __construct(TransferRepository $transferRepository, AccountService $accountService, PixService $pixService)
    {
        $this->transferRepository = $transferRepository;
        $this->accountService = $accountService;
        $this->pixService = $pixService;
    }

    public function create(array $data)
    {
        $transfer = $this->transferRepository->store($data);

        return $transfer;
    }

    public function transfer(array $requestData)
    {
        $from_account = $this->accountService->getAccountByAuth();

        $activeFromAccount = $this->accountService->checkActiveAccounts($from_account);
        if(!$activeFromAccount) throw new \Exception('from account must be active', 404);

        switch($requestData['type_transfer'])
        {
            case 'TED':
            $transfer = $this->ted($from_account, $requestData);
            break;
            case 'PIX':
            $transfer = $this->pix($from_account, $requestData);
            break;
        }

        return $transfer;
    }

    public function ted(Account $from_account, array $requestData)
    {
        $to_account = $this->accountService->getByAccountNumber($requestData['to_account']);
        if(!$to_account) throw new \Exception('to account not found', 404);

        $activeToAccount = $this->accountService->checkActiveAccounts($to_account);
        if(!$activeToAccount) throw new \Exception('to account must be active', 404);

        if($from_account->account_number === $to_account->number) throw new \Exception('cannot transfer to yourself', 404);

        $fee = 9.40;
        $amount = $requestData['amount'];
        $total = $amount + $fee;

        $enoughBalance = $this->accountService->checkBalance($from_account->balance, $total);
        if($enoughBalance) throw new \Exception('insufficient funds', 404);

        $data = [
            'uuid' => Str::uuid(10),
            'from_account' => $from_account->account_number,
            'to_account' => $to_account->account_number,
            'amount' => $amount,
            'fee' => $fee,
            'transfer_type' => 'TED'
        ];

        $transfer = $this->create($data);

        $from_account->balance -= $total;
        $from_account->save();

        $to_account->balance += $amount;
        $to_account->save();

        return $transfer;
    }

    public function pix(Account $from_account, array $requestData)
    {
        $keyReceiver = $this->pixService->findByPixKey($requestData['pix_key']);

        if(!$keyReceiver) throw new \Exception('key not found', 404);

        if($keyReceiver->account_id === $from_account->id) throw new \Exception('cannot transfer to yourself', 404);

        $to_account = $keyReceiver->account;

        $activeToAccount = $this->accountService->checkActiveAccounts($to_account);
        if(!$activeToAccount) throw new \Exception('to account must be active', 404);

        $enoughBalance = $this->accountService->checkBalance($from_account->balance, $requestData['amount']);
        if($enoughBalance) throw new \Exception('insufficient funds', 404);

        $data = [
            'uuid' => Str::uuid(10),
            'from_account' => $from_account->account_number,
            'to_account' => $to_account->account_number,
            'amount' => $requestData['amount'],
            'transfer_type' => 'PIX'
        ];

        $transfer = $this->create($data);

        $from_account->balance -= $requestData['amount'];
        $from_account->save();

        $to_account->balance += $requestData['amount'];
        $to_account->save();

        return $transfer;
    }
}
