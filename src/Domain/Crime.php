<?php

namespace App\Domain;

class Crime
{

    const PILLOW = 'PILLOW';
    const FLOWER_POT = 'FLOWER_POT';
    const POOP = 'POOP';
    const HOMEWORK = 'HOMEWORK';
    const CAKE = 'CAKE';
    const SHOES = 'SHOES';

    public function __construct(
        public readonly string $name,
        public readonly bool   $isCurrentCrime
    )
    {
        if (!in_array($name, [
            self::PILLOW,
            self::FLOWER_POT,
            self::POOP,
            self::HOMEWORK,
            self::CAKE,
            self::SHOES
        ])) {
            throw new \InvalidArgumentException('Invalid crime name');
        }
    }

    public function __equals(Crime $crime): bool
    {
        return $this->name === $crime->name;
    }

}