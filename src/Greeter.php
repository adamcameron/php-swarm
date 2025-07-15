<?php

namespace App;

class Greeter
{
    public const int FORMAL = 1;
    public const int INFORMAL = 2;

    public static function greet(string $name, int $style = self::FORMAL): string
    {
        if ($style === self::FORMAL) {
            return "Hello, $name";
        }
        return "Hi, $name";
    }
}
