<?php

namespace App\Services;

use App\Exceptions\InsufficientBalanceException;
use App\Repositories\AccountRepository;
use App\Repositories\CardRepository;
use App\Repositories\transactionRepository;

class TransactionService
{
    private $transactionRepository;
    private $cardRepository;
    private $accountRepository;

    public function __construct(
        transactionRepository $transactionRepository,
        CardRepository $cardRepository,
        AccountRepository $accountRepository
    )
    {
        $this->transactionRepository = $transactionRepository;
        $this->cardRepository = $cardRepository;
        $this->accountRepository = $accountRepository;
    }

    public function createTransaction($transactionData)
    {

        $sourceCard = $this->cardRepository->getByCardNumber($transactionData['source_card_number']);
        $sourceAccount = $sourceCard->account;

        $destinationCard = $this->cardRepository->getByCardNumber($transactionData['destination_card_number']);
        $destinationAccount = $destinationCard->account;

        do {
            if($sourceAccount->balance < $transactionData['amount']){
                throw new InsufficientBalanceException();
            }
            $updated = $this->accountRepository->decreaseAmount($sourceAccount, $transactionData['amount']);
        } while (!$updated);

        do {
            $updated = $this->accountRepository->increaseAmount($destinationAccount, $transactionData['amount']);
        } while (!$updated);

        return $this->transactionRepository->create($sourceCard->id, $destinationCard->id, $transactionData['amount']);
    }

}
