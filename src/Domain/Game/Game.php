<?php

namespace App\Domain\Game;

use App\Domain\BoardPlace;
use App\Domain\Crime;
use App\Domain\Dog\Dog;
use App\Domain\Evidence;
use App\Domain\Rule\IncorrectRuleException;
use App\Domain\Rule\Rule;
use App\Domain\Rule\RuleCompliance;

class Game
{
    /** @var Dog[] */
    public readonly array $dogs;

    /** @var BoardPlace[] */
    public readonly array $board;

    /** @var Rule[] */
    private array $rules;
    private string $crime;

    public function __construct(array $rules, string $crime)
    {
        $this->board = $this->buildBoard($crime);
        $this->dogs = $this->getDogs();
        $this->rules = $rules;
        $this->crime = $crime;
    }

    public function place(Dog $dog, int $boardPlaceNumber): void
    {
        $this->dogs[$dog->getName()]->place($this->board[$boardPlaceNumber]);
    }

    private function buildBoard(string $crime): array
    {
        $tennisBall = new Evidence(Evidence::TENNIS_BALL);
        $sock = new Evidence(Evidence::SOCK);
        $rawhide = new Evidence(Evidence::RAWHIDE);
        $stick = new Evidence(Evidence::STICK);
        $pawPrint = new Evidence(Evidence::PAW_PRINT);
        $ropeToy = new Evidence(Evidence::ROPE_TOY);

        $pillow = new Crime(Crime::PILLOW, $crime === Crime::PILLOW);
        $flowerPot = new Crime(Crime::FLOWER_POT, $crime === Crime::FLOWER_POT);
        $poop = new Crime(Crime::POOP, $crime === Crime::POOP);
        $homework = new Crime(Crime::HOMEWORK, $crime === Crime::HOMEWORK);
        $cake = new Crime(Crime::CAKE, $crime === Crime::CAKE);
        $shoes = new Crime(Crime::SHOES, $crime === Crime::SHOES);

        $boardPlace1 = new BoardPlace(1, $tennisBall, $sock, $homework);
        $boardPlace2 = new BoardPlace(2, $ropeToy, $pawPrint, $pillow);
        $boardPlace3 = new BoardPlace(3, $rawhide, $sock, $flowerPot);
        $boardPlace4 = new BoardPlace(4, $ropeToy, $stick, $cake);
        $boardPlace5 = new BoardPlace(5, $pawPrint, $tennisBall, $poop);
        $boardPlace6 = new BoardPlace(6, $rawhide, $stick, $shoes);

        $boardPlace1->addFrontBoard($boardPlace4);
        $boardPlace1->addLeftBoard($boardPlace2);
        $boardPlace1->addRightBoard($boardPlace6);

        $boardPlace2->addFrontBoard($boardPlace6);
        $boardPlace2->addLeftBoard($boardPlace3);
        $boardPlace2->addRightBoard($boardPlace1);

        $boardPlace3->addFrontBoard($boardPlace5);
        $boardPlace3->addLeftBoard($boardPlace4);
        $boardPlace3->addRightBoard($boardPlace2);

        $boardPlace4->addFrontBoard($boardPlace1);
        $boardPlace4->addLeftBoard($boardPlace5);
        $boardPlace4->addRightBoard($boardPlace3);

        $boardPlace5->addFrontBoard($boardPlace3);
        $boardPlace5->addLeftBoard($boardPlace6);
        $boardPlace5->addRightBoard($boardPlace4);

        $boardPlace6->addFrontBoard($boardPlace2);
        $boardPlace6->addLeftBoard($boardPlace1);
        $boardPlace6->addRightBoard($boardPlace5);

        $board = [];
        $board[$boardPlace1->placeNumber] = $boardPlace1;
        $board[$boardPlace2->placeNumber] = $boardPlace2;
        $board[$boardPlace3->placeNumber] = $boardPlace3;
        $board[$boardPlace4->placeNumber] = $boardPlace4;
        $board[$boardPlace5->placeNumber] = $boardPlace5;
        $board[$boardPlace6->placeNumber] = $boardPlace6;
        return $board;
    }

    /**
     * @return Dog[]
     */
    private function getDogs(): array
    {
        $dogs = [];
        $dogs[Dog::DAISY] = Dog::makeDaisy();
        $dogs[Dog::ACE] = Dog::makeAce();
        $dogs[Dog::CIDER] = Dog::makeCider();
        $dogs[Dog::SUZETTE] = Dog::makeSuzette();
        $dogs[Dog::BEANS] = Dog::makeBeans();
        $dogs[Dog::PEPPER] = Dog::makePepper();
        return $dogs;
    }

    public function getDogByName(string $dogName):Dog {
        return $this->dogs[$dogName];
    }

    /**
     * @return RuleCompliance[]
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

    /**
     * @return Dog[]
     */
    public function placedDogs(): array
    {
        $text = [];
        foreach ($this->dogs as $dog) {
            if ($dog->isPlaced()) {
                $text[] = $dog;
            }
        }
        return $text;
    }

    /**
     * @return Dog[]
     */
    public function unPlacedDogs(): array
    {
        $text = [];
        foreach ($this->dogs as $dog) {
            if (!$dog->isPlaced()) {
                $text[] = $dog;
            }
        }
        return $text;
    }

    public function isSolved(): bool
    {
        foreach ($this->rules as $rule) {
            if ($rule->meets($this) !== RuleCompliance::MeetsTheRule) {
                return false;
            }
        }
        return $this->dogThatMadeTheCrime() instanceof Dog;
    }

    public function dogThatMadeTheCrime(): ?Dog {
        foreach ($this->board as $boardPlace) {
            if ($boardPlace->isCurrentCrimePlace() && $boardPlace->getDog() instanceof Dog) {
                return $boardPlace->getDog();
            }
        }
        return null;
    }

    public function crime(): string {
        return $this->crime;
    }


}