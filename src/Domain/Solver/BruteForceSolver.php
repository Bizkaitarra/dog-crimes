<?php

namespace App\Domain\Solver;

use App\Domain\Dog\Dog;
use App\Domain\Game\Game;

final class BruteForceSolver
{
    /**
     * @throws GameCantBeSolvedException
     */
    public function __invoke(Game $game)
    {
        $places = [1, 2, 3, 4, 5, 6];
        foreach ($this->arrayWithUnplace($places) as $firstDogPlace) {
            $secondDogPlaces = array_diff($places, [$firstDogPlace]);
            foreach ($this->arrayWithUnplace($secondDogPlaces) as $secondDogPlace) {
                $thirdDogPlaces = array_diff($secondDogPlaces, [$secondDogPlace]);
                foreach ($this->arrayWithUnplace($thirdDogPlaces) as $thirdDogPlace) {
                    $fourthDogPlaces = array_diff($thirdDogPlaces, [$thirdDogPlace]);
                    foreach ($this->arrayWithUnplace($fourthDogPlaces) as $fourthDogPlace) {
                        $fifthDogPlaces = array_diff($fourthDogPlaces, [$fourthDogPlace]);
                        foreach ($this->arrayWithUnplace($fifthDogPlaces) as $fifthDogPlace) {
                            $sixthDogPlaces = array_diff($fifthDogPlaces, [$fifthDogPlace]);
                            foreach ($this->arrayWithUnplace($sixthDogPlaces) as $sixthDogPlace) {
                                echo "\n\nProbando\n";
                                echo sprintf("%s=%s\n", Dog::CIDER, $firstDogPlace);
                                echo sprintf("%s=%s\n", Dog::ACE, $secondDogPlace);
                                echo sprintf("%s=%s\n", Dog::DAISY, $thirdDogPlace);
                                echo sprintf("%s=%s\n", Dog::BEANS, $fourthDogPlace);
                                echo sprintf("%s=%s\n", Dog::PEPPER, $fifthDogPlace);
                                echo sprintf("%s=%s\n", Dog::SUZETTE, $sixthDogPlace);

                                $game->freeBoard();
                                if ($firstDogPlace !== null) {
                                    $game->place($game->getDogByName(Dog::CIDER), $firstDogPlace);
                                }
                                if ($secondDogPlace !== null) {
                                    $game->place($game->getDogByName(Dog::ACE), $secondDogPlace);
                                }
                                if ($thirdDogPlace !== null) {
                                    $game->place($game->getDogByName(Dog::DAISY), $thirdDogPlace);
                                }
                                if ($fourthDogPlace !== null) {
                                    $game->place($game->getDogByName(Dog::BEANS), $fourthDogPlace);
                                }
                                if ($fifthDogPlace !== null) {
                                    $game->place($game->getDogByName(Dog::PEPPER), $fifthDogPlace);
                                }
                                if ($sixthDogPlace !== null) {
                                    $game->place($game->getDogByName(Dog::SUZETTE), $sixthDogPlace);
                                }
                                if ($game->isSolved()) {
                                    return $game;
                                }
                            }
                        }
                    }
                }
            }
        }
        throw new GameCantBeSolvedException();
    }

    private
    function arrayWithUnplace(array $places): array
    {
        return array_merge($places, [null]);
    }

}