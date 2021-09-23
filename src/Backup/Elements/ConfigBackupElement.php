<?php

namespace ArtARTs36\GitHandler\Backup\Elements;

use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\Enum\ConfigSectionName;
use JetBrains\PhpStorm\ArrayShape;

final class ConfigBackupElement extends AbstractBackupElement
{
    public const IDENTITY = 'config';

    public function dump(GitHandler $git): array
    {
        return [
            'content' => $git->files()->getContent('.git/config'),
        ];
    }

    public function restore(
        GitHandler $git,
        #[ArrayShape(['content' => 'string'])]
        array $data
    ): void {
        $git->files()->createFile('.git/config', $data['content']);
    }
}
