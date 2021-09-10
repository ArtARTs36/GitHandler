<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Workflow;

use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\Contracts\Workflow\WorkflowElement;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;
use ArtARTs36\GitHandler\Workflow\WorkflowBuilding;

final class WorkflowBuildingTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Workflow\WorkflowBuilding::with
     */
    public function testWith(): void
    {
        $building = new WorkflowBuilding();

        $element = new class implements WorkflowElement
        {
            public function dump(GitHandler $git): array
            {
                return [];
            }

            public function restore(GitHandler $git, array $data): void
            {
                // TODO: Implement restore() method.
            }

            public function identity(): string
            {
                return 'test-element';
            }
        };

        $building->with($element);

        self::assertEquals([$element], $this->getPropertyValueOfObject($building, 'elements'));
    }
}
