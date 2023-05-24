<?php

namespace App\Domain\Solver;

use Exception;

final class GameCantBeSolvedException extends Exception
{
    public function __construct()
    {
        parent::__construct('Game cant be solved');
    }

}