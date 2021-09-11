<?php

namespace ArtARTs36\GitHandler\Workflow\Elements;

use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\Enum\ConfigSectionName;

class ConfigCommitWorkflowElement extends AbstractConfigWorkflowElement
{
    public const IDENTITY = 'config.commit';

    public function dump(GitHandler $git): array
    {
        return [
            ConfigSectionName::COMMIT => $git->config()->getSubject(ConfigSectionName::COMMIT),
        ];
    }
}
