<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Backup;

use ArtARTs36\GitHandler\Backup\ArrayBackupElementDict;
use ArtARTs36\GitHandler\Backup\Elements\HookBackupElement;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class ArrayBackupElementDictTest extends TestCase
{
    public function providerForTestGet(): array
    {
        return [
            [
                $exp1 = [new HookBackupElement()],
                [HookBackupElement::IDENTITY],
                $exp1,
            ],
            [
                $exp1,
                [HookBackupElement::class],
                $exp1,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestGet
     */
    public function testGet(array $input, array $called, array $expected): void
    {
        $dict = new ArrayBackupElementDict($input);

        self::assertEquals($expected, $dict->get($called));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Backup\ArrayBackupElementDict::getIterator
     */
    public function testGetIterator(): void
    {
        $dict = new ArrayBackupElementDict($expected = [new HookBackupElement()]);

        self::assertEquals($expected, (array) $dict->getIterator());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Backup\ArrayBackupElementDict::only
     */
    public function testOnlyIsImmutable(): void
    {
        $dict = new ArrayBackupElementDict([new HookBackupElement()]);

        self::assertNotEquals(spl_object_id($dict), spl_object_id($dict->only([HookBackupElement::IDENTITY])));
    }
}
