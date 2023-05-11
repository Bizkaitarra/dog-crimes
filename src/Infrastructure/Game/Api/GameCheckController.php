<?php

namespace App\Infrastructure\Game\Api;

use App\Application\Game\GameCheck;
use App\Application\Game\GameCheckRequest;
use App\Domain\Game\GameId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class GameCheckController extends AbstractController
{
    public function __invoke(
        GameCheck $gameCheck,
        Request   $request,
        string    $gameId
    )
    {
        $dogPositions = json_decode($request->getContent(), true);
        $gameCheckRequest = new GameCheckRequest(
            new GameId($gameId),
            $this->getValue($dogPositions, 'ace'),
            $this->getValue($dogPositions, 'beans'),
            $this->getValue($dogPositions, 'cider'),
            $this->getValue($dogPositions, 'daisy'),
            $this->getValue($dogPositions, 'pepper'),
            $this->getValue($dogPositions, 'suzette'),
        );

        $game = $gameCheck->__invoke($gameCheckRequest);

        $gameStatus = $game->status();

        $serializedRules = [];
        foreach ($gameStatus->rules() as $rule) {
            $serializedRules[] = [
                'text' => (string)$rule->rule,
                'compliance' => $rule->ruleCompliance->name
            ];

        }
        return new JsonResponse(
            [
                'gameId' => $gameId,
                'gameStatus' => [
                    'dogThatMadeTheCrime' => $gameStatus->dogThatMadeTheCrime,
                    'isSolved' => $gameStatus->isSolved,
                    'rules' => $serializedRules
                ]
            ]
        );

    }

    private function getValue(array $dogPositions, string $dogName): ?int {
        if (!isset($dogPositions[$dogName])) {
            return null;
        }

        $value = $dogPositions[$dogName];
        
        if ($value === '') {
            return null;
        }
        return $value;
    }
}