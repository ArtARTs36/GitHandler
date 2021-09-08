<?php

namespace ArtARTs36\GitHandler\Workflow\Elements;

use ArtARTs36\GitHandler\Config\Mapper\GitConfigKeyPropertyMapper;
use ArtARTs36\GitHandler\Contracts\Config\ConfigSubject;
use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\Contracts\Workflow\WorkflowElement;

/**
 * @internal
 */
abstract class AbstractConfigWorkflowElement extends AbstractWorkflowElement implements WorkflowElement
{
    protected $mapper;

    public function __construct(?GitConfigKeyPropertyMapper $mapper = null)
    {
        $this->mapper = $mapper ?? GitConfigKeyPropertyMapper::make();
    }

    /**
     * @param array<string, ConfigSubject> $data
     */
    public function restore(GitHandler $git, array $data): void
    {
        $config = $git->config();

        foreach ($data as $scope => $subject) {
            $configMap = $this->mapper->map($subject);

            foreach ($subject->toArray() as $field => $value) {
                $config->set($scope, $configMap[$field], $value);
            }
        }
    }
}
