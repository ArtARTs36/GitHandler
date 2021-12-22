<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function assertEqualsPropertyValueOfObject($object, string $property, $expected): void
    {
        self::assertEquals($expected, $this->getPropertyValueOfObject($object, $property));
    }

    protected function getPropertyValueOfObject($object, string $property)
    {
        $getter = function () use ($property) {
            return $this->$property;
        };

        return $getter->call($object);
    }

    protected function callMethodFromObject($object, string $method, ...$args)
    {
        $caller = function () use ($method, $args) {
            return $this->$method(...$args);
        };

        return $caller->call($object);
    }
}
