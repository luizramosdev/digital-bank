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

    public function store(array $data)
    {
        $transfer = $this->transfer->create($data);

        return $transfer;
    }
}
