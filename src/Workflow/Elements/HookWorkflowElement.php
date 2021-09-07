<?php

namespace ArtARTs36\GitHandler\Workflow\Elements;

use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\Contracts\Workflow\WorkflowElement;
use ArtARTs36\GitHandler\Data\Hook;
use ArtARTs36\GitHandler\Enum\HookName;

class HookWorkflowElement implements WorkflowElement
{
    public function dump(GitHandler $git): array
    {
        return $git->hooks()->getAll();
    }

    /**
     * @param array<Hook> $data
     */
    public function restore(GitHandler $git, array $data): void
    {
        $hooks = $git->hooks();

        foreach ($data as $hook) {
            $hooks->add(HookName::from($hook->name), $hook->script);
        }
    }
}
