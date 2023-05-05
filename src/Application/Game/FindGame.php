<?php

namespace App\Application\Game;

use App\Domain\Game\Game;
use App\Domain\Game\GameId;
use App\Domain\Game\GameRepository;

final class FindGame
{
    public function __construct(private readonly GameRepository $gameRepository)
    {
    }

    public function __invoke(GameId $gameId): Game
    {
        return $this->gameRepository->findGame($gameId);
    }

}