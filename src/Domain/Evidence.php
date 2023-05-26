<?php

namespace App\Domain;

class Evidence
{
    const ROPE_TOY = 'ROPE_TOY';
    const TENNIS_BALL = 'TENNIS_BALL';
    const SOCK = 'SOCK';
    const LEATHER_BONE = 'LEATHER_BONE';
    const STICK = 'STICK';
    const PAW_PRINT = 'PAW_PRINT';

    public function __construct(
        public readonly string $name
    )
    {
        if (!in_array($name, [
            self::ROPE_TOY,
            self::TENNIS_BALL,
            self::SOCK,
            self::LEATHER_BONE,
            self::STICK,
            self::PAW_PRINT
        ])) {
            throw new \InvalidArgumentException('Invalid evidence name');
        }
    }

}