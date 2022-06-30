<?php

namespace App\Http\Controllers;

use App\Exceptions\InsufficientBalanceException;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Services\TransactionService;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    private $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  $transactionRequest
     * @return Response
     * @throws InsufficientBalanceException
     */
    public function store(TransactionRequest $transactionRequest)
    {

        return response()->success(
            __('messages.received_successfully'),
            Response::HTTP_OK,
            new TransactionResource(
                $this->transactionService->createTransaction($transactionRequest->validated()
            ))
        );
    }
}
