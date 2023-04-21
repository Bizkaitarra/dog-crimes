<?php
namespace App\Dog;


class DogDefinition
{
    public function __construct(
        private ?string $name,
        private ?bool $hasBandana,
        private ?bool $hasTanTail,
        private ?bool $hasPerkyEars,
        private ?bool $hasWhitePaws,
        private ?bool $hasCollar,
        private ?bool $hasBow
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

    /**
     * @param Dog[] $dogs
     * @return Dog[]
     */
    public function getDogsThatMeets(array $dogs): array {
        return array_filter($dogs, fn($dog) => $this->meets($dog));
    }
}