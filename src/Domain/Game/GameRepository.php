<?php

namespace App\Domain\Game;

interface GameRepository
{
    public function findGame(GameId $gameId): Game;

    /**
     * @return GameId[]
     */
    public function findGameIds(): array;
}