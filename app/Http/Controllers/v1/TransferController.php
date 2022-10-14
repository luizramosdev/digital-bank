<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Services\TransferService;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransferRequest;

class TransferController extends Controller
{
    protected $transferService;

    public function __construct(TransferService $transferService)
    {
        $this->transferService = $transferService;
    }

    public function transfer(TransferRequest $request)
    {
        try {
            $transfer = $this->transferService->transfer($request->all());

            if(!$transfer) throw new \Exception('failed to create transfer', 400);

            return $transfer;

        } catch (\Exception $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ], $e->getCode());
        }

        return $transfer;
    }
}
