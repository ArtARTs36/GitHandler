<?php

namespace ArtARTs36\GitHandler\Workflow\Elements;

use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\Enum\ConfigScope;

class ConfigWorkflowElement extends AbstractConfigWorkflowElement
{
    public const IDENTITY = 'config';

    public function dump(GitHandler $git): array
    {
        return [
            ConfigScope::COMMIT => $git->config()->getSubject(ConfigScope::COMMIT),
        ];
    }
}
