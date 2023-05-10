<?php

namespace App\Application\Game;

use App\Domain\Game\GameId;

final class GameCheckRequest
{
    public function __construct(
        public readonly GameId $gameId,
        public readonly  ?int $ace,
        public readonly  ?int $beans,
        public readonly  ?int $cider,
        public readonly  ?int $daisy,
        public readonly  ?int $pepper,
        public readonly  ?int $suzette,
    )
    {
    }

}