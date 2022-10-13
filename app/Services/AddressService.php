<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Repositories\AddressRepository;
use App\Interfaces\Services\IAddressService;

class AddressService
{
    protected $addressRepository;

    public function __construct(AddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    public function create(array $requestData)
    {
        $requestData['address']['uuid'] = Str::uuid(10);
        $address = $this->addressRepository->store($requestData['address']);

        return $address;
    }
}
