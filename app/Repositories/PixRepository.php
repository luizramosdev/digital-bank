<?php

namespace App\Repositories;

use App\Models\Pix;

class PixRepository
{
    protected $pix;

    public function __construct(Pix $pix)
    {
        $this->pix = $pix;
    }

    public function store(array $requestData)
    {
        $pix = $this->pix->create($requestData);

        return $pix;
    }

    public function findByPixKey(string $key)
    {
        $pix = $this->pix->where('pix_key', $key)->first();

        return $pix;
    }

    public function findByAccountId(int $account_id)
    {
        $pix = $this->pix->where('account_id', $account_id)->first();

        return $pix;
    }
}
