<?php

namespace App\Entity;

use ReflectionClass;
use ReflectionProperty;

class Entity
{
    public function create()
    {
        $reflect = new ReflectionClass($this);
        /** @var ReflectionProperty $property */
        foreach($reflect->getProperties() as $property) {
            var_dump($property->getName());
        }
    }
}