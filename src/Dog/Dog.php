<?php
namespace App\Dog;

use App\BoardPlace;

class Dog
{

    private ?BoardPlace $boardPlace;

    public function __construct(
        private string $name,
        private bool $hasBandana,
        private bool $hasTanTail,
        private bool $hasPerkyEars,
        private bool $hasWhitePaws,
        private bool $hasCollar,
        private bool $hasBow
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function hasBandana(): bool
    {
        return $this->hasBandana;
    }

    public function hasTanTail(): bool
    {
        return $this->hasTanTail;
    }

    public function hasPerkyEars(): bool
    {
        return $this->hasPerkyEars;
    }

    public function hasWhitePaws(): bool
    {
        return $this->hasWhitePaws;
    }

    public function hasCollar(): bool
    {
        return $this->hasCollar;
    }

    public function hasBow(): bool
    {
        return $this->hasBow;
    }

    public function isPlaced(): bool
    {
        return $this->boardPlace instanceof BoardPlace;
    }

    public function getBoardPlace(): ?BoardPlace
    {
        return $this->boardPlace;
    }

    /**
     * @param BoardPlace $boardPlace
     */
    public function place(BoardPlace $boardPlace): void
    {
        $this->boardPlace = $boardPlace;
        if ($boardPlace->getDog() !== $this) {
            $boardPlace->placeDog($this);
        }
    }

}