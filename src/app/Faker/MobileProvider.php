<?php
namespace App\Faker;
use Faker\Provider\Base;
class MobileProvider extends Base
{
    protected static $mobile_prefixes = [
        '912' , '931' , '932' , '933' , '901' ,
        '921', '919' , '912' , '913' , '917' ,
        '915' , '916' , '910' , '939' , '938' ,
        '937' , '918' , '914' , '911' , '934'
    ];

    public function mobile(): string
    {

        $prefix = static::randomElement(static::$mobile_prefixes);
        $phone = '0' . $prefix . randomNumber(7);
        return (strlen($phone) !== 11 ? $phone . rand(1, 9) : $phone);

    }
}
