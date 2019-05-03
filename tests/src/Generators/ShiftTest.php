<?php

namespace drupol\phpermutations\Tests\Generators;

use drupol\phpermutations\Generators\Shift;
use drupol\phpermutations\Tests\AbstractTest;

/**
 * Class ShiftTest.
 *
 * @internal
 * @covers \drupol\phpermutations\Generators\Shift
 */
final class ShiftTest extends AbstractTest
{
    /**
     * The type.
     */
    const TYPE = 'shift';

    /**
     * The tests.
     *
     * @dataProvider dataProvider
     *
     * @param mixed $input
     * @param mixed $expected
     */
    public function testShift($input, $expected)
    {
        $shift = new Shift($input['dataset']);

        $this->assertSame($input['dataset'], $shift->getDataset());
        $this->assertSame($expected['count'], $shift->count());
    }
}
