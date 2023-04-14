<?php

namespace App;

class Evidence
{
    const ROPE_TOY = 'Rope Toy';
    const TENNIS_BALL = 'Tennis ball';
    const SOCK = 'Sock';
    const RAWHIDE = 'Rawhide';
    const STICK = 'Stick';
    const PAW_PRINT = 'Paw Print';

    public function __construct(
        public readonly string $name
    )
    {
    }

}