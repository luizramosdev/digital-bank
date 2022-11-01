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

        return response()->json([
            'code' => 200,
            'data' => $users
        ], 200);
    }

    public function store(StoreAccountRequest $request)
    {
        try {
            $user = $this->userService->create($request->all());

            return response()->json([
                'code' => 200,
                'message' => 'sucessfully created',
                'data' => $user
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'code' => 400,
                'message' => 'account creation error'
            ], 400);
        }
    }

    public function show($user_id)
    {
        try {
            $user = $this->userService->findUserById($user_id);

            if(!$user) throw new \Exception('user not found', 404);

            return response()->json([
                'code' => 200,
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function userAuth()
    {
        try {
            $user = $this->userService->getUserByAuth();

            if(!$user) throw new \Exception('user not found', 404);

            return response()->json([
                'code' => 200,
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }
}
