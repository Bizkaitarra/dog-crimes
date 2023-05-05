<?php

namespace App\Application\Game;

use App\Domain\Game\Game;
use App\Domain\Game\GameId;
use App\Domain\Game\GameRepository;

final class FindGamesIds
{
    public function __construct(private readonly GameRepository $gameRepository)
    {
    }

    /**
     * @return GameId[]
     */
    public function __invoke(): array
    {
        return $this->gameRepository->findGameIds();
    }

}