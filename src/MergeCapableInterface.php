<?php

namespace Dhii\Data\Merging;

use stdClass;
use Traversable;

/**
 * Interface for objects that can merge two data sets into one.
 *
 * @since [*next-version*]
 */
interface MergeCapableInterface
{
    /**
     * Merges two data sets into one.
     *
     * @since [*next-version*]
     *
     * @param array|stdClass|Traversable $first    The first data set.
     * @param array|stdClass|Traversable $second   The second data set.
     * @param MergeStrategyInterface     $strategy The merge strategy to use.
     *
     * @return array|stdClass|Traversable The resulting data set after merging $first and $second.
     */
    public function merge($first, $second, MergeStrategyInterface $strategy);
}
