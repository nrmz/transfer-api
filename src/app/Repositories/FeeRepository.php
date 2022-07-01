<?php

namespace App\Repositories;

use App\Models\Fee;

class FeeRepository
{
    private $model;

    public function __construct(Fee $model)
    {
        $this->model = $model;
    }

    public function create($transactionId, $fee_amount)
    {
        return $this->model->create([
            'transaction_id' => $transactionId,
            'fee_amount' => $fee_amount,
        ]);
    }


}
