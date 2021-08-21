<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Enum\ArchiveFormat;
use ArtARTs36\GitHandler\Support\TemporaryPathGenerator;

final class TemporaryPathGeneratorTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Support\TemporaryPathGenerator::toArchive
     * @covers \ArtARTs36\GitHandler\Support\TemporaryPathGenerator::buildArchiveName
     */
    public function testToArchiveNotRepeats(): void
    {
        $generator = $this->makeTemporaryPathGenerator();

        $format = ArchiveFormat::from(ArchiveFormat::ZIP);

        $paths = [
            $generator->toArchive($format),
            $generator->toArchive($format),
            $generator->toArchive($format),
            $generator->toArchive($format),
            $generator->toArchive($format),
        ];

        self::assertEquals($paths, array_unique($paths));
    }

    private function makeTemporaryPathGenerator(): TemporaryPathGenerator
    {
        return new TemporaryPathGenerator($this->mockFileSystem);
    }
}
