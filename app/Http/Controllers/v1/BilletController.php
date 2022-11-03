<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Services\BilletService;
use App\Http\Controllers\Controller;
use App\Http\Requests\BilletPaymentRequest;
use App\Http\Requests\BilletUpdateRequest;

class BilletController extends Controller
{
    protected $billetService;

    public function __construct(BilletService $billetService)
    {
        $this->billetService = $billetService;
    }

    public function store(Request $request)
    {
        try {
            $billet = $this->billetService->create($request->all());

            return response()->json([
                'code' => 200,
                'data' => $billet
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function show($bar_code)
    {
        try {
            $billet = $this->billetService->findBilletByBarCode($bar_code);

            return response()->json([
                'code' => 200,
                'data' => $billet
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function myGeneratedBillets()
    {
        try {
            $billets = $this->billetService->myGeneratedBillets();

            return response()->json([
                'code' => 200,
                'data' => $billets
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function myBilletsToPay()
    {
        try {
            $billets = $this->billetService->myBilletsToPay();

            return response()->json([
                'code' => 200,
                'data' => $billets
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function payment(BilletPaymentRequest $request)
    {
        try {
            $billet = $this->billetService->payment($request->all());

            return response()->json([
                'code' => 200,
                'data' => $billet
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function update(string $bar_code, BilletUpdateRequest $request)
    {
        try {
            $billet = $this->billetService->update($bar_code, $request->all());

            return response()->json([
                'code' => 200,
                'message' => 'successfully updated',
                'data' => $billet
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' =>  $e->getCode(),
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function cancellation(string $bar_code)
    {
        try {
            $billet = $this->billetService->cancellation($bar_code);

            return response()->json([
                'code' => 200,
                'message' => 'successfully canceled',
                'data' => $billet
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }
}
