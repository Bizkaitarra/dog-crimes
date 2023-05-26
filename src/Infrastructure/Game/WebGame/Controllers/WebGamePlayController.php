<?php

namespace App\Infrastructure\Game\WebGame\Controllers;

use App\Application\Game\GameCheck;
use App\Application\Game\GameCheckRequest;
use App\Domain\Game\GameId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

final class WebGamePlayController extends AbstractController
{
    public function __invoke(
        GameCheck $gameCheck,
        Request   $request,
        string    $gameId
    )
    {
        $gameCheckRequest = new GameCheckRequest(
            new GameId($gameId),
            null,
            null,
            null,
            null,
            null,
            null,
        );

        $game = $gameCheck->__invoke($gameCheckRequest);

        $gameStatus = $game->status();

        $serializedRules = [];
        foreach ($gameStatus->rules() as $rule) {
            $serializedRules[(string)$rule->rule] = $rule->ruleCompliance;
        }

        return $this->render('play.html.twig', [
            'gameId' => $gameId,
            'gameStatus' => $game->status()
        ]);
    }

}