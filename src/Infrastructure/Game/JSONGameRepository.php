<?php

namespace App\Infrastructure\Game;

use App\Domain\Dog\DogDefinition;
use App\Domain\Game\Game;
use App\Domain\Game\GameId;
use App\Domain\Game\GameRepository;
use App\Domain\Game\NotExistingGameException;
use App\Domain\Rule\DogAcrossToDogRule;
use App\Domain\Rule\DogRightToDogRule;
use App\Domain\Rule\Rule;
use App\Domain\Rule\XDogsWherePlayingOutside;

final class JSONGameRepository implements GameRepository
{
    private string $jsonFolder;
    public function __construct()
    {
        $this->jsonFolder = __DIR__ . '/../Games/';
    }

    public function findGameIds(): array
    {
        $result = [];
        $files = scandir($this->jsonFolder);
        foreach($files as $file) {
            $extension = pathinfo($file, PATHINFO_EXTENSION);
            if($extension == 'json') {
                $result[] = new GameId(basename($file, '.'.$extension));
            }
        }
        return $result;
    }

    /**
     * @throws NotExistingGameException
     */
    public function findGame(GameId $gameId): Game
    {
        $filename = $this->jsonFolder . $gameId->id . '.json';

        if (!file_exists($filename)) {
            throw new NotExistingGameException($gameId);
        }
        $fileContent = file_get_contents($filename);
        $gameData = json_decode($fileContent, true);

        $rules = [];
        if (isset($gameData['rules'])) {
            $rules = $this->parseRules($gameData['rules']);
        }
        return new Game(
            $rules,
            $gameData['crime']
        );
    }

    /**
     * @param array $rulesToParse
     * @return Rule[]
     */
    private function parseRules(array $rulesToParse): array
    {
        $rules = [];
        foreach ($rulesToParse as $ruleToParse) {
            switch ($ruleToParse['type']) {
                case 'DogAcrossToDogRule':
                    $rules[] = new DogAcrossToDogRule(
                        $ruleToParse['text'],
                        $this->parseDogDefinition($ruleToParse['firstDogDefinition']),
                        $this->parseDogDefinition($ruleToParse['secondDogDefinition'])
                    );
                    break;
                case 'DogRightToDogRule':
                    $rules[] = new DogRightToDogRule(
                        $ruleToParse['text'],
                        $this->parseDogDefinition($ruleToParse['firstDogDefinition']),
                        $this->parseDogDefinition($ruleToParse['secondDogDefinition'])
                    );
                    break;
                case 'XDogsWherePlayingOutside':
                    $rules[] = new XDogsWherePlayingOutside(
                        $ruleToParse['text'],
                        $ruleToParse['numberOfDogs'],
                    );
                    break;
            }
        }
        return $rules;
    }

    private function parseDogDefinition(array $dogDefinition): DogDefinition
    {
        return new DogDefinition(
            $dogDefinition['name'] ?? null,
            $dogDefinition['hasBandanna'] ?? null,
            $dogDefinition['hasTanTail'] ?? null,
            $dogDefinition['hasPerkyEars'] ?? null,
            $dogDefinition['hasWhitePaws'] ?? null,
            $dogDefinition['hasCollar'] ?? null,
            $dogDefinition['hasBow'] ?? null
        );
    }
}