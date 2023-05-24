<?php

namespace App\Domain\Dog;

use App\Domain\BoardPlace\BoardPlace;
use ArrayIterator;
use IteratorAggregate;
use Traversable;

final class DogCollection implements IteratorAggregate
{
    /**
     * @var Dog[]
     */
    private array $dogs = [];

    public function __construct(array $dogs)
    {
        foreach ($dogs as $dog) {
            $this->addDog($dog);
        }
    }

    public static function makeCompleteCollection(): DogCollection
    {
        return new self(
            [
                Dog::makeDaisy(),
                Dog::makeAce(),
                Dog::makeCider(),
                Dog::makeSuzette(),
                Dog::makeBeans(),
                Dog::makePepper()
            ]
        );
    }

    public function addDog(Dog $dog)
    {
        $this->dogs[$dog->getName()] = $dog;
    }

    public function placedDogs(): DogCollection
    {
        return new DogCollection(array_filter($this->dogs, fn($dog) => $dog->isPlaced()));
    }

    public function unPlacedDogs(): DogCollection
    {
        return new DogCollection(array_filter($this->dogs, fn($dog) => !$dog->isPlaced()));
    }

    public function empty(): bool
    {
        return count($this->dogs) == 0;
    }

    public function has(Dog $dog): bool
    {
        return isset($this->dogs[$dog->getName()]);
    }

    public function getDogByName(string $dogName): Dog
    {
        return $this->dogs[$dogName];
    }

    public function place(Dog $dog, BoardPlace $boardPlace): void
    {
        $this->getDogByName($dog->getName())->place($boardPlace);
    }
    public function unPlace(Dog $dog)
    {
        $this->getDogByName($dog->getName())->unPlace();
    }

    public function hasLessDogsThan(DogCollection $otherDogCollection): bool {
        return $this->count() < $otherDogCollection->count();
    }

    public function count(): int {
        return count($this->dogs);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->dogs);
    }

    public function toArray() {
        return $this->dogs;
    }


}