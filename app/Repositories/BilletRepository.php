<?php

namespace App\Repositories;

use App\Models\Billet;

class BilletRepository
{
    protected $billet;

    public function __construct(Billet $billet)
    {
        $this->billet = $billet;
    }

    public function store($data)
    {
        $billet = $this->billet->create($data);

        return $billet;
    }

    public function findBilletByAccountId(int $account_id)
    {
        $billets = $this->billet->where('account_id', $account_id)->get();

        return $billets;
    }

    public function findBilletByDocument(string $document)
    {
        $billets = $this->billet->where('payer_document', $document)->get();

        return $billets;
    }

    public function findBilletByBarCode(string $bar_code)
    {
        $billet = $this->billet->where('bar_code', $bar_code)->first();

        return $billet;
    }

    public function changeStatusBillet($billet, $status)
    {
        $billet->payment_status = $status;
        $billet->save();

        return $billet;
    }

    public function update(Billet $billet, array $requestData)
    {
        $billet = $billet->update($requestData);

        return $billet;
    }
}
