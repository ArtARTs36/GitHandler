<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Config;

use ArtARTs36\GitHandler\Config\Subjects\AbstractSubject;
use ArtARTs36\GitHandler\Tests\Unit\Config\Prototypes\Mask;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class AbstractSubjectTest extends TestCase
{
    public function providerForTestIsEmpty(): array
    {
        return [
            [
                ['field1' => '', 'field2' => ''],
                true,
            ],
            [
                ['field1' => 'value', 'field2' => ''],
                false,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestIsEmpty
     */
    public function testIsEmpty(array $subjectData, bool $state): void
    {
        $subject = new class($subjectData) extends AbstractSubject {
            public function __construct(array $subjectData)
            {
                foreach ($subjectData as $key => $value) {
                    $this->$key = $value;
                }
            }
        };

        self::assertEquals($state, $subject->isEmpty());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Config\Subjects\AbstractSubject::name
     */
    public function testName(): void
    {
        $subject = new Mask();

        self::assertEquals('mask', $subject->name());
    }
}
