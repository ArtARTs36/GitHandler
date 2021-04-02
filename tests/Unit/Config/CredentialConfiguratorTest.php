<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Config;

use ArtARTs36\GitHandler\Config\Configurators\CredentialConfigurator;
use ArtARTs36\GitHandler\Config\Subjects\Credential;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class CredentialConfiguratorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Config\Configurators\CredentialConfigurator::parse
     */
    public function testParse(): void
    {
        $configurator = new CredentialConfigurator();

        /** @var Credential $subject */
        $subject = $configurator->parse([
            'helper' => $helper = 'test_helper',
        ]);

        self::assertInstanceOf(Credential::class, $subject);
        self::assertEquals($helper, $subject->helper);
    }
}
