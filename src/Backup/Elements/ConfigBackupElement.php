<?php

namespace ArtARTs36\GitHandler\Backup\Elements;

use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\Enum\ConfigSectionName;
use JetBrains\PhpStorm\ArrayShape;

final class ConfigBackupElement extends AbstractBackupElement
{
    public const IDENTITY = 'config';

    /**
     * @return array<string, string>
     */
    #[ArrayShape(['content' => 'string'])]
    public function dump(GitHandler $git): array
    {
        return [
            'content' => $git->files()->getContent('.git/config'),
        ];
    }

    /**
     * @param array<string, string> $data
     */
    public function restore(
        GitHandler $git,
        #[ArrayShape(['content' => 'string'])]
        array $data
    ): void {
        $git->files()->createFile('.git/config', $data['content']);
    }
}
