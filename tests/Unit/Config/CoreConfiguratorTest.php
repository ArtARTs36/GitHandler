<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Config;

use ArtARTs36\GitHandler\Config\Configurators\CoreConfigurator;
use ArtARTs36\GitHandler\Config\Subjects\Core;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class CoreConfiguratorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Config\Configurators\CoreConfigurator::parse
     */
    public function testParse(): void
    {
        $configurator = new CoreConfigurator();

        //

        /** @var Core $core */
        $core = $configurator->parse([]);

        self::assertInstanceOf(Core::class, $core);
        self::assertEquals('', $core->autocrlf);
        self::assertFalse($core->ignoreCase);
        self::assertSame(0, $core->repositoryFormatVersion);
        self::assertFalse($core->bare);
        self::assertFalse($core->logAllRefUpdates);
        self::assertFalse($core->preComposeUnicode);
        self::assertFalse($core->fileMode);

        /** @var Core $core */
        $core = $configurator->parse([
            'autocrlf' => 'auto',
            'ignorecase' => 'true',
            'repositoryformatversion' => 5,
            'bare' => 'true',
            'logallrefupdates' => 'true',
            'precomposeunicode' => 'true',
            'filemode' => 'true',
        ]);

        self::assertInstanceOf(Core::class, $core);
        self::assertEquals('auto', $core->autocrlf);
        self::assertTrue($core->ignoreCase);
        self::assertSame(5, $core->repositoryFormatVersion);
        self::assertTrue($core->bare);
        self::assertTrue($core->logAllRefUpdates);
        self::assertTrue($core->preComposeUnicode);
        self::assertTrue($core->fileMode);
    }
}
