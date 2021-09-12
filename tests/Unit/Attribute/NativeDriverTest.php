<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Attribute;

use ArtARTs36\GitHandler\Attributes\Loader\NativeDriver;
use ArtARTs36\GitHandler\Tests\Support\TestAttribute;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class NativeDriverTest extends TestCase
{
    public function providerFromProperties(): array
    {
        return [
            [
                new class {
                    #[TestAttribute('test-key')]
                    public $key;
                },
                null,
                ['key' => [TestAttribute::class, ['value' => 'test-key']]],
            ],
        ];
    }

    /**
     * @dataProvider providerFromProperties
     * @covers \ArtARTs36\GitHandler\Attributes\Loader\NativeDriver::fromProperties
     * @covers \ArtARTs36\GitHandler\Attributes\Loader\NativeDriver::isInputToFilterOnly
     */
    public function testFromProperties(object $object, ?array $only, array $expected): void
    {
        if (PHP_VERSION_ID < 80000) {
            $this->markTestSkipped();
        }

        $driver = $this->makeNativeDriver();

        self::assertEquals(
            $expected,
            array_map(function (object $attribute) {
                return [get_class($attribute), get_object_vars($attribute)];
            }, $driver->fromProperties(new \ReflectionClass($object), $only))
        );
    }

    private function makeNativeDriver(): NativeDriver
    {
        return new NativeDriver();
    }
}
