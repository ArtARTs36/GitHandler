<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Attribute;

use ArtARTs36\GitHandler\Attributes\Loader\TokenDriver;
use ArtARTs36\GitHandler\Tests\Support\TestAttribute;
use ArtARTs36\GitHandler\Tests\Support\TestGitAttribute;
use ArtARTs36\GitHandler\Tests\Unit\Attribute\Prototypes\ClassHasGitAttribute;
use ArtARTs36\GitHandler\Tests\Unit\Attribute\Prototypes\ClassHasOtherAttribute;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class TokenDriverTest extends TestCase
{
    public function providerFromProperties(): array
    {
        return [
            [
                ClassHasOtherAttribute::class,
                null,
                [],
            ],
            [
                ClassHasGitAttribute::class,
                null,
                ['key' => [TestGitAttribute::class, ['value' => 'test-key2']]],
            ],
        ];
    }

    /**
     * @dataProvider providerFromProperties
     * @covers \ArtARTs36\GitHandler\Attributes\Loader\TokenDriver::fromProperties
     * @covers \ArtARTs36\GitHandler\Attributes\Loader\TokenDriver::getClass
     * @covers \ArtARTs36\GitHandler\Attributes\Loader\TokenDriver::getRequirements
     * @covers \ArtARTs36\GitHandler\Attributes\Loader\TokenDriver::extractPairs
     * @covers \ArtARTs36\GitHandler\Attributes\Loader\TokenDriver::extractArgs
     * @covers \ArtARTs36\GitHandler\Attributes\Loader\TokenDriver::isImplementsAttributeInterface
     * @covers \ArtARTs36\GitHandler\Attributes\Loader\NativeDriver::isInputToFilterOnly
     */
    public function testFromProperties(string $class, ?array $only, array $expected): void
    {
        $driver = $this->makeTokenDriver();

        self::assertEquals(
            $expected,
            array_map(function (object $attribute) {
                return [get_class($attribute), get_object_vars($attribute)];
            }, $driver->fromProperties(new \ReflectionClass($class), $only))
        );
    }

    private function makeTokenDriver(): TokenDriver
    {
        return new TokenDriver();
    }
}
