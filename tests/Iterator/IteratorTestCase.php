<?php

namespace Bolt\Filesystem\Tests\Iterator;

use Bolt\Filesystem\Tests\FilesystemTestCase;
use League\Flysystem;

abstract class IteratorTestCase extends FilesystemTestCase
{
    protected function assertIterator($expected, \Traversable $iterator)
    {
        $values = array_map(
            function (Flysystem\Handler $handler) {
                return $handler->getPath();
            },
            iterator_to_array($iterator)
        );

        sort($values);
        sort($expected);

        $this->assertEquals($expected, array_values($values));

        $this->assertIteratorInForeach($expected, $iterator);
    }

    protected function assertOrderedIterator($expected, \Traversable $iterator)
    {
        $values = array_map(
            function (Flysystem\Handler $handler) {
                return $handler->getPath();
            },
            iterator_to_array($iterator)
        );

        $this->assertEquals($expected, array_values($values));
    }

    /**
     * Same as IteratorTestCase::assertIterator with foreach usage.
     *
     * @param array        $expected
     * @param \Traversable $iterator
     */
    protected function assertIteratorInForeach($expected, \Traversable $iterator)
    {
        $values = [];
        foreach ($iterator as $handler) {
            /** @var Flysystem\Handler $handler */
            $this->assertInstanceOf('League\\Flysystem\\Handler', $handler);
            $values[] = $handler->getPath();
        }

        sort($values);
        sort($expected);

        $this->assertEquals($expected, array_values($values));
    }
}
