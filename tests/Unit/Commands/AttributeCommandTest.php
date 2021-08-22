<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Commands\AttributeCommand;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class AttributeCommandTest extends GitTestCase
{
    public function providerForTestGetMap(): array
    {
        return [
            [
                '',
                [],
            ],
            [
                'tests        export-ignore
.github export-ignore param1
phpunit.xml    export-ignore param1 param2
.gitattributes export-ignore',
                [
                    'tests' => [
                        'export-ignore',
                    ],
                    '.github' => [
                        'export-ignore',
                        'param1',
                    ],
                    'phpunit.xml' => [
                        'export-ignore',
                        'param1',
                        'param2',
                    ],
                    '.gitattributes' => [
                        'export-ignore',
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider providerForTestGetMap
     * @covers \ArtARTs36\GitHandler\Command\Commands\AttributeCommand::getMap
     * @covers \ArtARTs36\GitHandler\Files\AttributesFile::buildMap
     */
    public function testGetMap(string $content, array $expected): void
    {
        $command = $this->makeAttributeCommand();

        $this->mockFileSystem->createFile($command->getPath(), $content);

        self::assertEquals($expected, $command->getMap());
    }

    public function providerForTestFind(): array
    {
        return [
            [
                '/path/to/file export-ignore',
                '/path/to/file',
            ],
        ];
    }

    /**
     * @dataProvider providerForTestFind
     * @covers \ArtARTs36\GitHandler\Command\Commands\AttributeCommand::find
     */
    public function testFindOk(string $content, string $findPath): void
    {
        $command = $this->makeAttributeCommand();

        $this->mockFileSystem->createFile($command->getPath(), $content);

        self::assertEquals($findPath, $command->find($findPath)->pattern);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\AttributeCommand::find
     */
    public function testFindNull(): void
    {
        $command = $this->makeAttributeCommand();

        $this->mockFileSystem->createFile($command->getPath(), '');

        self::assertNull($command->find('index.php'));
    }

    public function providerForTestAdd(): array
    {
        return [
            [
                // empty .gittatributes
                '', 'my-pattern', ['value'], "my-pattern value\n",
            ],
            [
                // .gitattributes not exists
                false, 'my-pattern', ['value'], "my-pattern value\n",
            ],
            [
                // .gitattributes has requested pattern and equals attribute
                "my-pattern value\n", 'my-pattern', ['value'], "my-pattern value\n",
            ],
        ];
    }

    /**
     * @dataProvider providerForTestAdd
     * @covers \ArtARTs36\GitHandler\Command\Commands\AttributeCommand::add
     * @covers \ArtARTs36\GitHandler\Command\Commands\AttributeCommand::isFileExists
     * @covers \ArtARTs36\GitHandler\Command\Commands\AttributeCommand::saveFromMap
     * @param bool|string $startContent
     */
    public function testAdd(
        $startContent,
        string $pattern,
        array $attributes,
        string $endContent
    ): void {
        $command = $this->makeAttributeCommand();

        $startContent !== false && $this->mockFileSystem->createFile($command->getPath(), $startContent);

        $command->add($pattern, $attributes);

        self::assertEquals($endContent, $this->mockFileSystem->getFileContent($command->getPath()));
    }

    public function providerForTestDelete(): array
    {
        return [
            [
                'path1 attribute1',
                'path1',
                true,
            ],
            [
                'path1 attribute1',
                'path2',
                false,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestDelete
     * @covers \ArtARTs36\GitHandler\Command\Commands\AttributeCommand::delete
     */
    public function testDelete(string $startContent, string $pattern, bool $state): void
    {
        $command = $this->makeAttributeCommand();

        $this->mockFileSystem->createFile($command->getPath(), $startContent);

        self::assertEquals($state, $command->delete($pattern));
    }

    private function makeAttributeCommand(): AttributeCommand
    {
        return new AttributeCommand($this->mockFileSystem, $this->mockGitContext);
    }
}
