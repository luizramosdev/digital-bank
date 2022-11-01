<?php

namespace App\Http\Controllers\v1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\TransferService;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransferRequest;
use App\Http\Requests\TransferPixRequest;
use App\Http\Requests\TransferTedRequest;

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

            if(empty($request['pix_key']) && empty($request['to_account'])) throw new \Exception('necessary to inform pix key or to account', 404);

            $transfer = $this->transferService->transfer($request->all());

            if(!$transfer) throw new \Exception('failed to create transfer', 400);

            return response()->json([
                'code' => 200,
                'data' => $transfer
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ], $e->getCode());
        }

        return $transfer;
    }

    // public function transferPix(TransferPixRequest $request)
    // {
    //     try {
    //         $transfer = $this->transferService->transfer($request->all());

    //         if(!$transfer) throw new \Exception('failed to create transfer', 400);

    //         return $transfer;

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'code' => $e->getCode(),
    //             'message' => $e->getMessage()
    //         ], $e->getCode());
    //     }
    // }
}
