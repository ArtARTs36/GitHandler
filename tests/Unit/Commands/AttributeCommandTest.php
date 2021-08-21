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

    private function makeAttributeCommand(): AttributeCommand
    {
        return new AttributeCommand($this->mockFileSystem, $this->mockGitContext);
    }
}
