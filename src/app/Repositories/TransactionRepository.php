<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository
{
    private $model;

    public function __construct(Transaction $model)
    {
        $this->model = $model;
    }

    public function create($sourceCardId, $destinationCardId, $amount)
    {
        return $this->model->create([
            'source_card_id' => $sourceCardId,
            'destination_card_id' => $destinationCardId,
            'amount' => $amount
        ]);
    }


}
