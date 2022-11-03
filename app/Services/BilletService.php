<?php

namespace App\Services;

use App\Models\Billet;
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

        $this->accountService->checkActiveAccounts($from_account);

        $payer = $this->userService->findUserByDocument($requestData['payer_document']);
        if(!$payer) throw new \Exception('payer not found', 404);

        $timeZone = new DateTimeZone('America/Sao_Paulo');
        $now = date('Y-m-d');
        $due_date = $requestData['due_date'];
        $max_due_date = date('Y-m-d', strtotime($now. ' + 90 days'));

        $now = DateTime::createFromFormat('Y-m-d', $now, $timeZone);
        $due_date = DateTime::createFromFormat('Y-m-d', $due_date, $timeZone);
        $max_due_date = DateTime::createFromFormat('Y-m-d', $max_due_date, $timeZone);

        if($due_date < $now) throw new \Exception('due date entered has passed', 404);

        if($due_date > $max_due_date) throw new \Exception('the maximum expiration date is up to 90 days', 404);

        $data = [
            'uuid' => Str::uuid(10),
            'account_id' => $from_account->id,
            'bar_code' => random_int(1000000000, 9999999999),
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

    public function payment(array $requestData)
    {
        //busca o boleto pelo codigo de barras
        $billet = $this->billetRepository->findBilletByBarCode($requestData['bar_code']);

        if(!$billet) throw new \Exception('billet not found', 404);

        // verifica se a data de pagamento é maior que a data de vencimento
        $timeZone = new DateTimeZone('America/Sao_Paulo');
        $now = date('Y-m-d');
        $due_date = $billet->due_date;

        $now = DateTime::createFromFormat('Y-m-d', $now, $timeZone);
        $due_date = DateTime::createFromFormat('Y-m-d', $due_date, $timeZone);

        if($now > $due_date) throw new \Exception('billet is expired', 404);

        // verifica se o status do boleto é diferente de em aberto
        if($billet->payment_status !== 'OPENED') throw new \Exception('the billet status must be opened', 404);

        // pega a conta do usuário atraves da autenticacao
        $from_account = $this->accountService->getAccountByAuth();

        //verifica se a conta logada está ativa ou inativa
        $this->accountService->checkActiveAccounts($from_account);

        //busca a conta recebedora
        $to_account = $this->accountService->findAccountById($billet->account_id);
        if(!$to_account) throw new \Exception('account not found', 404);

        //verifica se a conta recebedora está ativa ou inativa
        $this->accountService->checkActiveAccounts($to_account);

        //verifica se a conta pagadora possui saldo suficiente
        $this->accountService->checkBalance($from_account->balance, $billet->amount);

        // retira o valor do boleto da conta do pagador
        $this->accountService->balanceExit($from_account, $billet->amount);

        // adiciona o valor do boleto na conta do recebedor
        $this->accountService->addBalance($to_account, $billet->amount);

        //altera o status do boleto
        $status = 'PAID';
        $billet = $this->changeStatusBillet($billet, $status);

        return $billet;
    }

    public function changeStatusBillet($billet, string $status)
    {
        $billet = $this->billetRepository->changeStatusBillet($billet, $status);

        return $billet;
    }

    public function update(string $bar_code, array $requestData)
    {
        //localizar o boleto
        $billet = $this->findBilletByBarCode($bar_code);

        //pegar a conta logada atraves da autenticacao
        $account = $this->accountService->getAccountByAuth();

        //somente o emissor do boleto pode editar
        if($billet->account_id !== $account->id) throw new \Exception('the billet can only be changed by the issuer', 404);

        //verificar se o status é igual a OPENED
        if($billet->payment_status !== 'OPENED') throw new \Exception('to update the billet it must be opened', 404);

        //verificar o boleto já está vencido e também se passou do prazo máximo que é 90 dias a primeira data de vencimento informada
        $timeZone = new DateTimeZone('America/Sao_Paulo');
        $now = date('Y-m-d');
        $requestDueDate = $requestData['due_date'];
        $max_due_date = date('Y-m-d', strtotime($billet->due_date. ' + 90 days'));

        $now = DateTime::createFromFormat('Y-m-d', $now, $timeZone);
        $requestDueDate = DateTime::createFromFormat('Y-m-d', $requestDueDate, $timeZone);
        $billet_due_date = DateTime::createFromFormat('Y-m-d', $billet->due_date, $timeZone);
        $max_due_date = DateTime::createFromFormat('Y-m-d', $max_due_date, $timeZone);

        if($now > $billet_due_date) throw new \Exception('billet is expired', 404);

        if($requestDueDate > $max_due_date) throw new \Exception('Date must be less than 90 days from the original due date', 404);

        //atualiza boleto
        $this->billetRepository->update($billet, $requestData);

        return $billet;
    }

    public function cancellation(string $bar_code)
    {
        //localiza o boleto
        $billet = $this->findBilletByBarCode($bar_code);

        //somente o emissor do boleto pode cancelar
        $account = $this->accountService->getAccountByAuth();

        if($billet->account_id !== $account->id) throw new \Exception('the billet can only be changed by the issuer', 404);

        //o boleto não pode estar com o status pago
        if($billet->payment_status !== 'OPENED') throw new \Exception('to cancellation the billet it must be opened', 404);

        //atualizar status para cancelado
        $status = 'CANCELED';

        $this->billetRepository->changeStatusBillet($billet, $status);

        return $billet;
    }

}
