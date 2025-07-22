<?php

namespace App\Core;

trait Singleton
{
    private static array $instances = [];

    public static function getInstance(): static
    {
        $calledClass = static::class;
        if (empty(self::$instances[$calledClass])) {
            self::$instances[$calledClass] = new static();
        }
        return self::$instances[$calledClass];
    }
}