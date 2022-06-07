<?php

/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Razoyo\AnimalProfile\Animal;

class AnimalData
{
    const TYPE_CAT = 'cat';
    const TYPE_DOG = 'dog';
    const TYPE_LLAMA = 'llama';
    const TYPE_ANTEATER = 'anteater';

    private static $animals = null;
    private static $animal_list = null;

    public static function getAnimalClasses()
    {
        if (static::$animals === null) {
            static::$animals = [
                self::TYPE_CAT => new Cat(),
                self::TYPE_DOG => new Dog(),
                self::TYPE_LLAMA => new Llama(),
                self::TYPE_ANTEATER => new Anteater(),
            ];
        }

        return static::$animals;
    }

    public static function getAnimalList()
    {
        if (static::$animal_list === null) {
            static::$animal_list = [
                self::TYPE_CAT => static::useProperCase(self::TYPE_CAT),
                self::TYPE_DOG => static::useProperCase(self::TYPE_DOG),
                self::TYPE_LLAMA => static::useProperCase(self::TYPE_LLAMA),
                self::TYPE_ANTEATER => static::useProperCase(self::TYPE_ANTEATER),
            ];
        }

        return static::$animal_list;
    }

    private static function useProperCase($word)
    {
        return ucwords(strtolower($word));
    }
}