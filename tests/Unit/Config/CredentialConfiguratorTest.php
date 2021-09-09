<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Config;

use ArtARTs36\GitHandler\Config\Configurators\CredentialConfigurator;
use ArtARTs36\GitHandler\Config\Subjects\Credential;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class CredentialConfiguratorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Config\Configurators\CredentialConfigurator::parse
     * @covers \ArtARTs36\GitHandler\Config\Subjects\Credential::__construct
     */
    public function testParse(): void
    {
        $configurator = new CredentialConfigurator();

        /** @var Credential $subject */
        $subject = $configurator->parse([
            'helper' => $helper = 'test_helper',
        ]);

        self::assertEquals($helper, $subject->helper);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Config\Configurators\CredentialConfigurator::parse
     * @covers \ArtARTs36\GitHandler\Config\Subjects\Credential::__construct
     */
    public function testParseInstanceOf(): void
    {
        $configurator = new CredentialConfigurator();

        /** @var Credential $subject */
        $subject = $configurator->parse([
            'helper' => 'test_helper',
        ]);

        self::assertInstanceOf(Credential::class, $subject);
    }
}
