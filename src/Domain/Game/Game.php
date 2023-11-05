<?php

namespace App\Domain\Game;

use App\Domain\BoardPlace\Board;
use App\Domain\Dog\Dog;
use App\Domain\Dog\DogCollection;
use App\Domain\Evidence;
use App\Domain\Rule\IncorrectRuleException;
use App\Domain\Rule\Rule;

class Game
{
    public readonly DogCollection $dogs;

    public readonly Board $board;

    /** @var Rule[] */
    private array $rules;
    private string $crime;

    public function __construct(array $rules, string $crime)
    {
        $this->board = Board::makeBaseBoard($crime);
        $this->dogs = DogCollection::makeCompleteCollection();
        $this->rules = $rules;
        $this->crime = $crime;
    }

    public function place(Dog $dog, int $boardPlaceNumber): void
    {
        $this->dogs->place($dog,$this->board->getBoardPlaceByNumber($boardPlaceNumber));
    }

    public function unPlace(Dog $dog): void
    {
        $this->dogs->unPlace($dog);
    }

    public function freeBoard(): void {
        foreach ($this->dogs as $dog) {
            $dog->unPlace();
        }
    }

    public function getDogByName(string $dogName):Dog {
        return $this->dogs->getDogByName($dogName);
    }

    /**
     * @return bool[]
     * @throws IncorrectRuleException
     */
    public function rules(): array
    {
        $text = [];
        foreach ($this->rules as $rule) {
            $text[$rule->__toString()] = $rule->meets($this);
        }
        return $text;
    }

    public function placedDogs(): DogCollection
    {
        return $this->dogs->placedDogs();
    }

    public function unPlacedDogs(): DogCollection
    {
        return $this->dogs->unPlacedDogs();
    }

    public function isSolved(): bool
    {
        foreach ($this->rules as $rule) {
            if (!$rule->meets($this)) {
                return false;
            }
        }
        return $this->dogThatMadeTheCrime() instanceof Dog;
    }

    public function status(): GameStatus
    {
        $gameStatus = new GameStatus(
            $this->isSolved(),
            $this->dogThatMadeTheCrime()
        );
        foreach ($this->rules as $rule) {
            $gameStatus->addRule($rule, $rule->meets($this));
        }
        return $gameStatus;
    }

    public function dogThatMadeTheCrime(): ?Dog {
        $boardPlace = $this->board->crimeBoardPlace();
        return $boardPlace->getDog();
    }

    public function crime(): string {
        return $this->crime;
    }
}