<?php

namespace App\Repositories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    private $model;
    private const TRANSACTION_REPORT_INTERVAL = 10;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function listUserWithMaxTransaction(): array
    {

        $usersWithMaxTransactions = $this->get_user_list_with_max_transactions();
        return $this->cal_deposit_and_withdraw_transactions($usersWithMaxTransactions);

    }

    private function get_user_list_with_max_transactions(): Collection
    {

        return DB::table('users')
            ->leftJoin('accounts', function ($join) {
                $join->on('accounts.user_id', '=', 'users.id');
            })
            ->join('cards', function ($join) {
                $join->on('cards.account_id', '=', 'accounts.id');
            })
            ->join('transactions', function ($join) {
                $join->on('transactions.source_card_id', '=', 'cards.id')->orOn('transactions.destination_card_id', '=', 'cards.id');
            })
            ->where('transactions.created_at', '>', Carbon::now()->subMinutes(self::TRANSACTION_REPORT_INTERVAL)->toDateTimeString())
            ->select(['users.id','users.name', 'users.mobile', DB::raw('COUNT(transactions.id) as transactions_count')])->groupBy('users.id')
            ->orderBy('transactions_count','desc')
            ->limit(3)->get();

    }

    public function cal_deposit_and_withdraw_transactions($usersWithMaxTransactions): array
    {
        $listUserWithTransactions = [];

        foreach ($usersWithMaxTransactions as $user){
            $userItem = new \stdClass();
            $userItem->user = $user;
            $userItem->user->depositTransactions = $this->model->find($user->id)->depositTransactions
                ->where('created_at', '>', Carbon::now()->subMinutes(self::TRANSACTION_REPORT_INTERVAL)->toDateTimeString());
            $userItem->user->withdrawTransactions = $this->model->find($user->id)->withdrawTransactions
                ->where('created_at', '>', Carbon::now()->subMinutes(self::TRANSACTION_REPORT_INTERVAL)->toDateTimeString());
            $listUserWithTransactions[] = $userItem;
        }
        return $listUserWithTransactions;

    }

    public function create($userData)
    {
        return $this->model->create([
            'name' => $userData['name'],
            'mobile' => $userData['mobile'],
            'password' => bcrypt($userData['password'])
        ]);
    }


}
