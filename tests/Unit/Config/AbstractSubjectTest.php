<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Config;

use ArtARTs36\GitHandler\Config\Subjects\AbstractSubject;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class AbstractSubjectTest extends TestCase
{
    public function testIsEmpty(): void
    {
        $subject = new class extends AbstractSubject {
            private $oneField;

            private $twoField = '';
        };

        self::assertTrue($subject->isEmpty());

        //

        $subject = new class extends AbstractSubject {
            protected $oneField = 'value';
        };

        self::assertFalse($subject->isEmpty());
    }
}
