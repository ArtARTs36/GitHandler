<?php

namespace ArtARTs36\GitHandler\Backup\Elements;

use ArtARTs36\GitHandler\Config\Mapper\ConfigKeyPropertyMapper;
use ArtARTs36\GitHandler\Contracts\Config\ConfigSubject;
use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\Contracts\Workflow\BackupElement;

/**
 * @internal
 */
abstract class AbstractConfigBackupElement extends AbstractBackupElement implements BackupElement
{
    protected $mapper;

    public function __construct(?ConfigKeyPropertyMapper $mapper = null)
    {
        $this->mapper = $mapper ?? ConfigKeyPropertyMapper::make();
    }

    /**
     * @param array<string, ConfigSubject> $data
     */
    public function restore(GitHandler $git, array $data): void
    {
        $config = $git->config();

        foreach ($data as $section => $subject) {
            $configMap = $this->mapper->map($subject);

            foreach ($subject->toArray() as $field => $value) {
                $config->set($section, $configMap[$field], $value);
            }
        }
    }
}
