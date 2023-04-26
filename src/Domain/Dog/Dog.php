<?php
namespace App\Domain\Dog;

use App\Domain\BoardPlace;

class Dog
{
    const DAISY = 'Daisy';
    const ACE = 'Ace';
    const CIDER = 'Cider';
    const SUZETTE = 'Suzette';
    const BEANS = 'Beans';
    const PEPPER = 'Pepper';

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

    public static function makeDaisy(): Dog
    {
        return new self(
            self::DAISY,
            true,
            true,
            false,
            false,
            false,
            false
        );
    }

    public static function makeAce(): Dog
    {
        return new self(
            self::ACE,
            true,
            false,
            true,
            false,
            false,
            false
        );
    }

    public static function makeCider(): Dog
    {
        return new self(
            self::CIDER,
            false,
            false,
            false,
            true,
            true,
            false
        );
    }

    public static function makeSuzette(): Dog
    {
        return new self(
            self::SUZETTE,
            false,
            false,
            false,
            false,
            true,
            true
        );
    }

    public static function makeBeans(): Dog
    {
        return new self(
            self::BEANS,
            false,
            true,
            false,
            false,
            false,
            true
        );
    }

    public static function makePepper(): Dog
    {
        return new self(
            self::PEPPER,
            false,
            false,
            true,
            true,
            false,
            false
        );
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
        return isset($this->boardPlace) && $this->boardPlace instanceof BoardPlace;
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
        $boardPlace->placeDog($this);
    }

}