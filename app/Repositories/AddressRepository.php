<?php

namespace App\Repositories;

use App\Models\Address;
use App\Interfaces\Repositories\IAddressRepository;

class AddressRepository
{
    protected $address;

    public function __construct(Address $address)
    {
        $this->address = $address;
    }
    public function store(array $requestData)
    {
        $address = $this->address->create($requestData);

        return $address;
    }
}
