<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $userRepository;
    protected $addressService;
    protected $accountService;

    public function __construct(UserRepository $userRepository, AddressService $addressService, AccountService $accountService)
    {
        $this->userRepository = $userRepository;
        $this->addressService = $addressService;
        $this->accountService = $accountService;
    }

    public function getAll()
    {
        $user = $this->userRepository->getAll();

        return $user;
    }

    public function create(array $requestData)
    {
        $address = $this->addressService->create($requestData);

        $requestData['users']['uuid'] = Str::uuid(10);
        $requestData['users']['address_id'] = $address->id;
        $requestData['users']['password'] = Hash::make($requestData['users']['password']);

        $user = $this->userRepository->store($requestData['users']);

        $requestData['accounts']['uuid'] = Str::uuid(10);
        $requestData['accounts']['agency_id'] = 1;
        $requestData['accounts']['user_id'] = $user->id;
        $requestData['accounts']['account_number'] = rand(9, 99999);

        $account = $this->accountService->create($requestData['accounts']);

        return $user;
    }

    public function getUserByAuth()
    {
        $user = auth()->user();

        return $user;
    }

    public function getUserById(int $id)
    {
        $user = $this->userRepository->getUserById($id);

        return $user;
    }

    public function findUserByDocument(string $document)
    {
        $user = $this->userRepository->findUserByDocument($document);

        return $user;
    }
}
