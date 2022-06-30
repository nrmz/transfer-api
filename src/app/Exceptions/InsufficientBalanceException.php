<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class InsufficientBalanceException extends Exception
{
    //
    public function render($request)
    {
        return response()->error(
            __('messages.not_enough_money'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
