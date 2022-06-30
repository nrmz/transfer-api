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
if (!function_exists('to_english_numbers')) {
    function to_english_numbers(string $string): string
    {
        $persianDigitsSeries1 = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $persianDigitsSeries2 = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١', '٠'];
        $allPersianDigits = array_merge($persianDigitsSeries1, $persianDigitsSeries2);
        $replaces = [...range(0, 9), ...range(0, 9)];

        return str_replace($allPersianDigits, $replaces, $string);
    }
}
