<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Workflow;

use ArtARTs36\GitHandler\Tests\Support\TestWorkflowElement;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;
use ArtARTs36\GitHandler\Workflow\Elements\HookWorkflowElement;
use ArtARTs36\GitHandler\Workflow\BackupBuilding;

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
     * @covers \ArtARTs36\GitHandler\Workflow\BackupBuilding::with
     * @covers \ArtARTs36\GitHandler\Workflow\BackupBuilding::__construct
     */
    public function testWith(): void
    {
        $building = new BackupBuilding();
        $element = new TestWorkflowElement();

        $building->with($element);

        self::assertEquals([$element], $this->getPropertyValueOfObject($building, 'elements'));
    }

    /**
     * @dataProvider providerForTestGet
     * @covers \ArtARTs36\GitHandler\Workflow\BackupBuilding::get
     */
    public function testGet(array $initial, array $searched, array $expected): void
    {
        $building = new BackupBuilding($initial);

        self::assertEquals($expected, $building->get($searched));
    }
}
