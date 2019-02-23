<?php

namespace Dhii\Data\Merging;

/**
 * Interface for objects that represent a merge strategy by processing a single key-value entry.
 *
 * @since [*next-version*]
 */
interface MergeStrategyInterface
{
    /**
     * Merges a key-value pair into a subject array
     *
     * @since [*next-version*]
     *
     * @param array      $subject The subject to merge into.
     * @param int|string $key     The key of the entry to merge in.
     * @param mixed      $value   The value of the entry to merge in.
     *
     * @return array The merged result.
     */
    public function mergeEntry($subject, $key, $value);
}
