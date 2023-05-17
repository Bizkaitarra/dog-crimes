<?php
namespace App\Domain\Dog;


class DogDefinition
{
    public function __construct(
        private readonly ?string $name,
        private readonly ?bool   $hasBandana,
        private readonly ?bool   $hasTanTail,
        private readonly ?bool   $hasPerkyEars,
        private readonly ?bool   $hasWhitePaws,
        private readonly ?bool   $hasCollar,
        private readonly ?bool $hasBow
    )
    {
    }

    private function meets(Dog $dog) {
        if ($this->name !== null && $this->name !== $dog->getName()) {
            return false;
        }
        if ($this->hasBandana !== null && $this->hasBandana !== $dog->hasBandana()) {
            return false;
        }
        if ($this->hasTanTail !== null && $this->hasTanTail !== $dog->hasTanTail()) {
            return false;
        }
        if ($this->hasPerkyEars !== null && $this->hasPerkyEars !== $dog->hasPerkyEars()) {
            return false;
        }
        if ($this->hasWhitePaws !== null && $this->hasWhitePaws !== $dog->hasWhitePaws()) {
            return false;
        }
        if ($this->hasCollar !== null && $this->hasCollar !== $dog->hasCollar()) {
            return false;
        }
        if ($this->hasBow !== null && $this->hasBow !== $dog->hasBow()) {
            return false;
        }
        return true;
    }

    public function getDogsThatMeets(DogCollection $dogs): DogCollection {
        $dogsThatMeets = new DogCollection([]);
        foreach ($dogs as $dog) {
            if ($this->meets($dog)) {
                $dogsThatMeets->addDog($dog);
            }
        }
        return $dogsThatMeets;
    }
}