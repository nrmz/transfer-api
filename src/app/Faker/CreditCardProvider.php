<?php
namespace App\Faker;
use Faker\Provider\Base;
class CreditCardProvider extends Base
{
    protected static array $prefixes = [4,5,6];

    public function creditNumber(): string
    {

        $prefix = static::randomElement(static::$prefixes);
        return $prefix . randomNumber(15, false);

    }
}
