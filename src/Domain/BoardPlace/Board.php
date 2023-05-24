<?php

namespace App\Domain\BoardPlace;

use App\Domain\Crime;
use App\Domain\Evidence;
use ArrayIterator;
use IteratorAggregate;
use Traversable;

final class Board implements IteratorAggregate
{
    /**
     * @var BoardPlace[]
     */
    private array $boardPlaces = [];

    public function __construct(array $boardPlaces)
    {
        foreach ($boardPlaces as $boardPlace) {
            $this->addBoardPlace($boardPlace);
        }
    }

    public static function makeBaseBoard(string $crime): self
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

        return new self([
            $boardPlace1,
            $boardPlace2,
            $boardPlace3,
            $boardPlace4,
            $boardPlace5,
            $boardPlace6
        ]);
    }

    public function addBoardPlace(BoardPlace $boardPlace)
    {
        $this->boardPlaces[$boardPlace->placeNumber] = $boardPlace;
    }

    public function boardPlacesWithDogs(): Board
    {
        return new Board(array_filter($this->boardPlaces, fn($boardPlace) => $boardPlace->hasDog()));
    }

    public function freeBoardPlaces(): Board
    {
        return new Board(array_filter($this->boardPlaces, fn($boardPlace) => !$boardPlace->hasDog()));
    }

    public function empty(): bool
    {
        return count($this->boardPlaces) == 0;
    }

    public function getBoardPlaceByNumber(int $placeNumber): BoardPlace
    {
        return $this->boardPlaces[$placeNumber];
    }

    public function crimeBoardPlace(): BoardPlace
    {
        foreach ($this->boardPlaces as $boardPlace) {
            if ($boardPlace->isCurrentCrimePlace()) {
                return $boardPlace;
            }
        }
        throw new \LogicException('No crime board place found');
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->boardPlaces);
    }

    public function freeBoardPlacesWithEvidence(Evidence $evidence): Board
    {
        return new Board(
            array_filter(
                $this->boardPlaces,
                fn($boardPlace) => $boardPlace->getDog() === null && $boardPlace->hasEvidence($evidence)
            )
        );
    }

    public function toArray(): array
    {
        return $this->boardPlaces;
    }
}