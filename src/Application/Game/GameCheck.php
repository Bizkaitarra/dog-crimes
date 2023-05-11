<?php

namespace App\Application\Game;

use App\Domain\Dog\Dog;
use App\Domain\Game\Game;
use App\Domain\Game\GameRepository;

final class GameCheck
{
    public function __construct(
        private readonly GameRepository $gameRepository
    )
    {
    }

    public function __invoke(
        GameCheckRequest $gameCheckRequest
    ): Game
    {
        $game = $this->gameRepository->findGame($gameCheckRequest->gameId);
        if ($gameCheckRequest->ace !== null) {
            $game->place($game->getDogByName(Dog::ACE), $gameCheckRequest->ace);
        }
        if ($gameCheckRequest->beans !== null) {
            $game->place($game->getDogByName(Dog::BEANS), $gameCheckRequest->beans);
        }
        if ($gameCheckRequest->cider !== null) {
            $game->place($game->getDogByName(Dog::CIDER), $gameCheckRequest->cider);
        }
        if ($gameCheckRequest->daisy !== null) {
            $game->place($game->getDogByName(Dog::DAISY), $gameCheckRequest->daisy);
        }
        if ($gameCheckRequest->pepper !== null) {
            $game->place($game->getDogByName(Dog::PEPPER), $gameCheckRequest->pepper);
        }
        if ($gameCheckRequest->suzette !== null) {
            $game->place($game->getDogByName(Dog::SUZETTE), $gameCheckRequest->suzette);
        }
        return $game;
    }

}