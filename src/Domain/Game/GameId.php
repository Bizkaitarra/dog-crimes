<?php

namespace App\Domain\Game;

final class GameId
{
    public function __construct(public readonly string $id)
    {
    }

}