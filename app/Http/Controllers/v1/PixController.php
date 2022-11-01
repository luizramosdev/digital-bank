<?php

namespace App\Http\Controllers\v1;

use App\Services\PixService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePixRequest;

class PixController extends Controller
{
    protected $pixService;

    public function __construct(PixService $pixService)
    {
        $this->pixService = $pixService;
    }

    public function store(StorePixRequest $request)
    {
        try {
            $pix = $this->pixService->create($request->all());

            return response()->json([
                'code' => 200,
                'data' => $pix
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function show($key)
    {
        try {
            $pix = $this->pixService->findByPixKey($key);

            if(!$pix) throw new \Exception('pix not found', 404);

            return response()->json([
                'code' => 200,
                'data' => $pix
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }
}
