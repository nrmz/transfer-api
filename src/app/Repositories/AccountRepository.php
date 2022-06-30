<?php

namespace App\Repositories;

use App\Models\Account;
use App\Models\Card;
use App\Models\Transfer;

class AccountRepository
{
    private $model;

    public function __construct(Account $account)
    {
        $this->model = $account;
    }

    public function decreaseAmount($account, $amount)
    {
        return $this->model->where('id', $account->id)->where('updated_at', $account->updated_at)
            ->update(['balance' => $account->balance - $amount]);
    }

    public function IncreaseAmount($account, $amount)
    {
        return $this->model->where('id', $account->id)->where('updated_at', $account->updated_at)
            ->update(['balance' => $account->balance + $amount]);
    }

}
