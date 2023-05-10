<?php

namespace App\Infrastructure\Game\Api;

use Symfony\Component\HttpFoundation\Request;

final class GameCheckController
{
    public function __invoke(Request $request, string $gameId)
    {
        $dogPositions = json_decode($request->getContent(), true);

    }
}