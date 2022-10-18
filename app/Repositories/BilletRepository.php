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
}
