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

    public function leftBoard(): BoardPlace
    {
        return $this->leftBoard;
    }

    public function rightBoard(): BoardPlace
    {
        return $this->rightBoard;
    }

    public function frontBoard(): BoardPlace
    {
        return $this->frontBoard;
    }

    public function hasEvidence(Evidence $evidence): bool {
        return isset($this->evidences[$evidence->name]);
    }

    public function isCurrentCrimePlace(): bool {
        return $this->crime->isCurrentCrime;
    }

    public function isNextTo(BoardPlace $boardPlace): bool {
        return $this->leftBoard->placeNumber === $boardPlace->placeNumber ||
            $this->rightBoard->placeNumber === $boardPlace->placeNumber;
    }

    public function isInFrontOf(BoardPlace $boardPlace): bool {
        return $this->frontBoard->placeNumber === $boardPlace->placeNumber;
    }

    public function isInRightOf(BoardPlace $boardPlace): bool {
        return $this->rightBoard->placeNumber === $boardPlace->placeNumber;
    }

    public function isInLeftOf(BoardPlace $boardPlace): bool {
        return $this->leftBoard->placeNumber === $boardPlace->placeNumber;
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

    public function placeDog(Dog $dog) {
        $this->dog = $dog;
        if ($this !== $dog->getBoardPlace()) {
            $dog->place($this);
        }
    }

    public function __toString(): string
    {
        return $this->placeNumber;
    }


}