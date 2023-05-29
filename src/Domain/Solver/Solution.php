<?php

namespace App\Domain\Solver;

use App\Domain\Game\Game;

final class Solution
{
    /**
     * @param Game[] $games
     */
    public function __construct(
        public readonly array   $games
    )
    {
    }

    public function count(): int
    {
        return count($this->games);
    }

}