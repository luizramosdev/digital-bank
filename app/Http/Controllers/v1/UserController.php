<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAccountRequest;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAll();

        return response()->json([$users]);
    }

    public function store(StoreAccountRequest $request)
    {
        try {
            $user = $this->userService->create($request->all());

            return response()->json([
                'code' => 200,
                'message' => 'sucessfully created'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'code' => 400,
                'message' => 'account creation error'
            ], 400);
        }


    }
}
