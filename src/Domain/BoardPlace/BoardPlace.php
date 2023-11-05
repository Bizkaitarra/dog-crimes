<?php
namespace App\Domain\BoardPlace;

use App\Domain\Crime;
use App\Domain\Dog\Dog;
use App\Domain\Evidence;

class BoardPlace
{
    /** @var Evidence[] */
    private array $evidences = [];
    private BoardPlace $leftBoard;
    private BoardPlace $rightBoard;
    private BoardPlace $frontBoard;
    private ?Dog $dog;

    public function __construct(
        public readonly int $placeNumber,
        Evidence $firstEvidence,
        Evidence $secondEvidence,
        private readonly Crime $crime
    )
    {
        $this->evidences[$firstEvidence->name] = $firstEvidence;
        $this->evidences[$secondEvidence->name] = $secondEvidence;
    }

    public function addLeftBoard(BoardPlace $boardPlace): void {
        $this->leftBoard = $boardPlace;
    }

    public function addRightBoard(BoardPlace $boardPlace): void {
        $this->rightBoard = $boardPlace;
    }

    public function addFrontBoard(BoardPlace $boardPlace): void {
        $this->frontBoard = $boardPlace;
    }

    public function hasEvidence(Evidence $evidence): bool {
        return isset($this->evidences[$evidence->name]);
    }

    public function isCurrentCrimePlace(): bool {
        return $this->crime->isCurrentCrime;
    }

    public function hasCrime(Crime $crime):bool {
        return $this->crime->__equals($crime);
    }

    public function isNextTo(BoardPlace $boardPlace): bool {
        return $this->leftBoard->placeNumber === $boardPlace->placeNumber ||
            $this->rightBoard->placeNumber === $boardPlace->placeNumber;
    }

    public function isInFrontOf(BoardPlace $boardPlace): bool {
        return $this->frontBoard->placeNumber === $boardPlace->placeNumber;
    }

    public function isInRightOf(BoardPlace $boardPlace): bool {
        return $this->leftBoard->placeNumber === $boardPlace->placeNumber;
    }

    public function isInLeftOf(BoardPlace $boardPlace): bool {
        return $this->rightBoard->placeNumber === $boardPlace->placeNumber;
    }

    public function isInDistance(int $distance, BoardPlace $boardPlace): bool {
        $rightBoard = $this->rightBoard;
        for ($i=1; $i<$distance; $i++) {
            $rightBoard = $rightBoard->rightBoard;
        }
        $leftBoard = $this->leftBoard;
        for ($i=1; $i<$distance; $i++) {
            $leftBoard = $leftBoard->leftBoard;
        }
        return $rightBoard->placeNumber === $boardPlace->placeNumber ||
            $leftBoard->placeNumber === $boardPlace->placeNumber;
    }

    public function getDog(): ?Dog
    {
        if (isset($this->dog)) {
            return $this->dog;
        }

        return null;
    }

    public function hasDog(): bool {
        return $this->getDog() instanceof Dog;
    }

    public function placeDog(Dog $dog): void {
        $this->dog = $dog;
        if ($this !== $dog->getBoardPlace()) {
            $dog->place($this);
        }
    }

    public function free(): void
    {
        $this->dog = null;
    }

    public function __toString(): string
    {
        return (string) $this->placeNumber;
    }




}