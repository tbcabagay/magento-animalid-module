<?php

/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Razoyo\AnimalProfile\Animal;

class AnimalHandler
{
    public function getAnimal($animal)
    {
        $animals = $this->getAnimalClasses();
        if (! isset($animals[$animal])) {
            return false;
        }

        return $animals[$animal];
    }

    public function getAnimalList()
    {
        return AnimalData::getAnimalList();
    }

    public function getDefaultAnimal()
    {
        return AnimalData::TYPE_CAT;
    }

    private function getAnimalClasses()
    {
        return AnimalData::getAnimalClasses();
    }
}
