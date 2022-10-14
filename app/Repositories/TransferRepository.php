<?php

namespace App\Repositories;

use App\Models\Transfer;

class TransferRepository
{
    protected $transfer;

    public function __construct(Transfer $transfer)
    {
        $this->transfer = $transfer;
    }

    public function store(array $requestData)
    {
        $transfer = $this->transfer->create($requestData);

        return $transfer;
    }
}
