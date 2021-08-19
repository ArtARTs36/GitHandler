<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Config;

use ArtARTs36\GitHandler\Config\Configurators\BranchConfigurator;
use ArtARTs36\GitHandler\Config\Subjects\BranchList;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class BranchConfiguratorTest extends TestCase
{
    public function providerForTestParse(): array
    {
        return [
            [
                [
                    'branch.master.remote' => 'origin',
                    'branch.master.merge' => 'refs/heads/master',
                    'branch.2.x.remote' => 'origin',
                    'branch.2.x.merge' => 'refs/heads/2.x',
                    'branch.readme.remote' => 'origin',
                    'branch.readme.merge' => 'refs/heads/readme',
                    'branch.update-shell-command.remote' => 'origin',
                    'branch.update-shell-command.merge' => 'refs/heads/update-shell-command',
                    'branch.remove-webmozart-assert.remote' => 'origin',
                    'branch.remove-webmozart-assert.merge' => 'refs/heads/remove-webmozart-assert',
                    'branch.branch-configurator.remote' => 'origin',
                    'branch.branch-configurator.merge' => 'refs/heads/branch-configurator',
                ],
                [
                    'master' =>
                        [
                            'name' => 'master',
                            'remote' => 'origin',
                            'merge' => 'refs/heads/master',
                        ],
                    '2.x' =>
                        [
                            'name' => '2.x',
                            'remote' => 'origin',
                            'merge' => 'refs/heads/2.x',
                        ],
                    'readme' =>
                        [
                            'name' => 'readme',
                            'remote' => 'origin',
                            'merge' => 'refs/heads/readme',
                        ],
                    'update-shell-command' =>
                        [
                            'name' => 'update-shell-command',
                            'remote' => 'origin',
                            'merge' => 'refs/heads/update-shell-command',
                        ],
                    'remove-webmozart-assert' =>
                        [
                            'name' => 'remove-webmozart-assert',
                            'remote' => 'origin',
                            'merge' => 'refs/heads/remove-webmozart-assert',
                        ],
                    'branch-configurator' =>
                        [
                            'name' => 'branch-configurator',
                            'remote' => 'origin',
                            'merge' => 'refs/heads/branch-configurator',
                        ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider providerForTestParse
     * @covers \ArtARTs36\GitHandler\Config\Configurators\BranchConfigurator::parse
     * @covers \ArtARTs36\GitHandler\Config\Configurators\BranchConfigurator::buildBranchName
     */
    public function testParse(array $raw, array $expected): void
    {
        $configurator = new BranchConfigurator();
        /** @var BranchList $result */
        $result = $configurator->parse($raw);

        self::assertEquals($expected, $this->prepareResult($result));
    }

    private function prepareResult(BranchList $list): array
    {
        $dict = [];

        foreach ($list->branches as $branch) {
            $dict[$branch->name] = $branch->toArray();
        }

        return $dict;
    }
}
