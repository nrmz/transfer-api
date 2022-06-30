<?php

//get rand int
if (!function_exists('randomNumber')) {
    function randomNumber($length = 20, $int = false): int|string
    {
        $numbers = "0123456789";
        $number = '';

        for ($i = 1; $i <= $length; $i++) {
            $num = $numbers[rand($i === 1 ? $i : 0, strlen($numbers) - 1)];
            $number .= $num;
        }

        return $int ? (integer) $number : (string) $number;
    }
}
