<?php

namespace App\Domain\Game;

use Exception;

final class NotExistingGameException extends Exception
{
    public function __construct(GameId $gameId)
    {
        parent::__construct(sprintf('Game %s not found', $gameId->id));
    }
}