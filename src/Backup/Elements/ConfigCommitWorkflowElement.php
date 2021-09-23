<?php

namespace ArtARTs36\GitHandler\Backup\Elements;

use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\Enum\ConfigSectionName;

final class ConfigCommitWorkflowElement extends AbstractConfigBackupElement
{
    public const IDENTITY = 'config.commit';

    public function dump(GitHandler $git): array
    {
        return [
            ConfigSectionName::COMMIT => $git->config()->getSubject(ConfigSectionName::COMMIT),
        ];
    }
}
