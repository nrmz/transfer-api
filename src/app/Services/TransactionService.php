<?php

namespace App\Services;

use App\Exceptions\InsufficientBalanceException;
use App\Repositories\AccountRepository;
use App\Repositories\CardRepository;
use App\Repositories\transactionRepository;
use App\Http\Notification\Interface\SendSmsInterface;
use App\Repositories\FeeRepository;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    private $transactionRepository;
    private $cardRepository;
    private $accountRepository;
    private $wageRepository;
    private $sendSmsService;

    private const FEE = 500;

    public function __construct(
        transactionRepository $transactionRepository,
        CardRepository $cardRepository,
        AccountRepository $accountRepository,
        FeeRepository $feeRepository,
        SendSmsInterface $sendSmsService
    )
    {
        $this->transactionRepository = $transactionRepository;
        $this->cardRepository = $cardRepository;
        $this->accountRepository = $accountRepository;
        $this->sendSmsService = $sendSmsService;
        $this->feeRepository = $feeRepository;
    }

    public function createTransaction($transactionData)
    {

        $sourceCard = $this->cardRepository->getByCardNumber($transactionData['source_card_number']);
        $sourceAccount = $sourceCard->account;

        $destinationCard = $this->cardRepository->getByCardNumber($transactionData['destination_card_number']);
        $destinationAccount = $destinationCard->account;


        DB::beginTransaction();
        try {
            do {
                if($sourceAccount->balance < $transactionData['amount'] + self::FEE){
                    throw new InsufficientBalanceException();
                }
                $updated = $this->accountRepository->decreaseAmount($sourceAccount, $transactionData['amount'] + self::FEE);
            } while (!$updated);

            do {
                $updated = $this->accountRepository->increaseAmount($destinationAccount, $transactionData['amount']);
            } while (!$updated);

            $transaction = $this->transactionRepository->create($sourceCard->id, $destinationCard->id, $transactionData['amount']);

            $this->sendSmsService->send($sourceAccount->user->mobile,
                __('messages.withdraw',[
                    'source' => $sourceCard->card_number,
                    'destination' => $destinationCard->card_number,
                    'amount' => $transactionData['amount'],
                    'balance' => $sourceAccount->balance,
                    'date' => $transaction->created_at,
                    'transaction_id' => $transaction->id,
                ]));

            $this->sendSmsService->send($destinationAccount->user->mobile,
                __('messages.deposit',[
                    'source' => $sourceCard->card_number,
                    'destination' => $destinationCard->card_number,
                    'amount' => $transactionData['amount'],
                    'balance' => $destinationAccount->balance,
                    'date' => $transaction->created_at,
                    'transaction_id' => $transaction->id
                ]));

            $this->feeRepository->create($transaction->id, self::FEE);

            DB::commit();

            return $transaction;
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw new \ErrorException(__('messages.try_again_later'));
        }

    }

}
