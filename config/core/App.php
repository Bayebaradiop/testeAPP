<?php

namespace App\Core;

use Symfony\Component\Yaml\Yaml;

class App
{
    private static array $container = [];
    private static bool $initialized = false;

    public static function run(): void
    {
        self::initialize();
    }

    private static function initialize(): void
    {
        if (self::$initialized) {
            return;
        }

        $dependencies = Yaml::parseFile(__DIR__ . '/../../config/service.yaml');

        foreach ($dependencies as $category => $services) {
            foreach ($services as $key => $class) {
                self::$container[$category][$key] = fn() => $class::getInstance();
            }
        }

        self::$initialized = true;
    }


    public static function getDependency(string $key): mixed
    {
        self::initialize();

        foreach (self::$container as $category => $services) {
            if (array_key_exists($key, $services)) {
                $factory = $services[$key];
                return $factory();
            }
        }

        throw new \Exception("Dependency not found: " . $key);
    }
}

