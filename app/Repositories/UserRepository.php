<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAll()
    {
        $user = $this->user->all();

        return $user;
    }

    public function store(array $requestData)
    {
        $user = $this->user->create($requestData);

        return $user;
    }


}
