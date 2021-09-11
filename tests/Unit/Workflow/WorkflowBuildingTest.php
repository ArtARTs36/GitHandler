<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Workflow;

use ArtARTs36\GitHandler\Tests\Support\TestWorkflowElement;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;
use ArtARTs36\GitHandler\Workflow\Elements\HookWorkflowElement;
use ArtARTs36\GitHandler\Workflow\WorkflowBuilding;

final class WorkflowBuildingTest extends TestCase
{
    public function providerForTestGet(): array
    {
        return [
            [
                [
                    $element = new TestWorkflowElement(),
                    new HookWorkflowElement(),
                ],
                [
                    'test-element',
                ],
                [
                    $element,
                ],
            ]];
    }

    /**
     * @covers \ArtARTs36\GitHandler\Workflow\WorkflowBuilding::with
     * @covers \ArtARTs36\GitHandler\Workflow\WorkflowBuilding::__construct
     */
    public function testWith(): void
    {
        $building = new WorkflowBuilding();
        $element = new TestWorkflowElement();

        $building->with($element);

        self::assertEquals([$element], $this->getPropertyValueOfObject($building, 'elements'));
    }

    /**
     * @dataProvider providerForTestGet
     * @covers \ArtARTs36\GitHandler\Workflow\WorkflowBuilding::get
     */
    public function testGet(array $initial, array $searched, array $expected): void
    {
        $building = new WorkflowBuilding($initial);

        self::assertEquals($expected, $building->get($searched));
    }
}
