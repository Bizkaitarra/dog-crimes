<?php

namespace App\Infrastructure\Game;

use App\Domain\Crime;
use App\Domain\Dog\DogDefinition;
use App\Domain\Evidence;
use App\Domain\Game\Game;
use App\Domain\Game\GameId;
use App\Domain\Game\GameRepository;
use App\Domain\Game\NotExistingGameException;
use App\Domain\Rule\DogAcrossToDogRule;
use App\Domain\Rule\DogLeftToDogRule;
use App\Domain\Rule\DogNextToDogRule;
use App\Domain\Rule\DogPlacedInAPlaceWithCrime;
use App\Domain\Rule\DogPlacedInAPlaceWithDistanceRule;
use App\Domain\Rule\DogPlacedInAPlaceWithEvidence;
use App\Domain\Rule\DogRightToDogRule;
use App\Domain\Rule\DogsWherePlayingOutside;
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
                case 'DogLeftToDogRule':
                    $rules[] = new DogLeftToDogRule(
                        $ruleToParse['text'],
                        $this->parseDogDefinition($ruleToParse['firstDogDefinition']),
                        $this->parseDogDefinition($ruleToParse['secondDogDefinition'])
                    );
                    break;
                case 'DogNextToDogRule':
                    $rules[] = new DogNextToDogRule(
                        $ruleToParse['text'],
                        $this->parseDogDefinition($ruleToParse['firstDogDefinition']),
                        $this->parseDogDefinition($ruleToParse['secondDogDefinition'])
                    );
                    break;
                case 'DogPlacedInAPlaceWithDistanceRule':
                    $rules[] = new DogPlacedInAPlaceWithDistanceRule(
                        $ruleToParse['text'],
                        $ruleToParse['distance'],
                        $this->parseDogDefinition($ruleToParse['firstDogDefinition']),
                        $this->parseDogDefinition($ruleToParse['secondDogDefinition'])
                    );
                    break;
                case 'XDogsWherePlayingOutside':
                    $rules[] = new XDogsWherePlayingOutside(
                        $ruleToParse['text'],
                        $ruleToParse['numberOfDogs']
                    );
                    break;
                case 'DogPlacedInAPlaceWithEvidence':
                    $rules[] = new DogPlacedInAPlaceWithEvidence(
                        $ruleToParse['text'],
                        $this->parseDogDefinition($ruleToParse['firstDogDefinition']),
                        $this->parseEvidence($ruleToParse['evidence'])
                    );
                    break;
                case 'DogPlacedInAPlaceWithCrime':
                    $rules[] = new DogPlacedInAPlaceWithCrime(
                        $ruleToParse['text'],
                        $this->parseDogDefinition($ruleToParse['firstDogDefinition']),
                        $this->parseCrime($ruleToParse['crime'])
                    );
                    break;
                case 'DogsWherePlayingOutside':
                    $dogDefinitions = [];
                    $definitions = $ruleToParse['dogDefinitions'];
                    foreach ($definitions as $definition) {
                        $dogDefinitions[] = $this->parseDogDefinition($definition);
                    }
                    $rules[] = new DogsWherePlayingOutside(
                        $ruleToParse['text'],
                        $dogDefinitions
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

    private function parseEvidence(string $evidence): Evidence
    {
        return new Evidence($evidence);
    }

    private function parseCrime(string $crime): Crime
    {
        return new Crime($crime, false);
    }
}