<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Command\GitCommandBuilder;
use ArtARTs36\ShellCommand\ShellCommander;

final class GitCommandBuilderTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\GitCommandBuilder::make
     */
    public function testMakeWithoutParam(): void
    {
        $builder = $this->makeGitCommandBuilder('git', __DIR__);

        $settings = $builder->make()->getSettings();

        self::assertEquals([
            'bin' => "'git'",
            'dir' => "'". __DIR__ ."'",
        ], [
            'bin' => (string) end($settings),
            'dir' => (string) reset($settings),
        ]);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\GitCommandBuilder::make
     */
    public function testMakeWithParam(): void
    {
        $builder = $this->makeGitCommandBuilder('git', __DIR__);

        $settings = $builder->make('new_dir')->getSettings();

        self::assertEquals([
            'bin' => "'git'",
            'dir' => "'new_dir'",
        ], [
            'bin' => (string) end($settings),
            'dir' => (string) reset($settings),
        ]);
    }

    private function makeGitCommandBuilder(string $bin, string $dir):  GitCommandBuilder
    {
        return new GitCommandBuilder(new ShellCommander(), $bin, $dir);
    }
}
