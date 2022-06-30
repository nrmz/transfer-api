<?php

namespace App\Repositories;

use App\Models\Card;
use App\Models\Transfer;

class CardRepository
{
    private $model;

    public function __construct(Card $card)
    {
        $this->model = $card;
    }

    public function getByCardNumber($cardNumber)
    {
        return $this->model->whereCardNumber($cardNumber)->firstOrFail();
    }


}
