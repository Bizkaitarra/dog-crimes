<?php
namespace App;

class Crime
{

    const PILLOW = 'Pillow';
    const FLOWER_POT = 'Flower Pot';
    const POOP = 'Poop';
    const HOMEWORK = 'Homework';
    const CAKE = 'Cake';
    const SHOES = 'Shoes';

    public function __construct(
        public readonly string $name,
        public readonly bool $isCurrentCrime
    )
    {
    }

}