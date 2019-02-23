# Dhii - Merge Strategy Interface

[![Build Status](https://travis-ci.com/dhii/merge-strategy-interface.svg?branch=develop)](https://travis-ci.com/dhii/merge-strategy-interface)
[![Code Climate](https://codeclimate.com/github/dhii/merge-strategy-interface/badges/gpa.svg)](https://codeclimate.com/github/dhii/merge-strategy-interface)
[![Test Coverage](https://codeclimate.com/github/dhii/merge-strategy-interface/badges/coverage.svg)](https://codeclimate.com/github/dhii/merge-strategy-interface/coverage)
[![Latest Stable Version](https://poser.pugx.org/dhii/merge-strategy-interface/version)](https://packagist.org/packages/dhii/merge-strategy-interface)
[![Latest Unstable Version](https://poser.pugx.org/dhii/merge-strategy-interface/v/unstable)](https://packagist.org/packages/dhii/merge-strategy-interface)
[![This package complies with Dhii standards](https://img.shields.io/badge/Dhii-Compliant-green.svg?style=flat-square)][Dhii]

Interfaces for standards-compliant merge strategies.

# Introduction

Merging two data sets is often trivial and can be accomplished through simple iteration or even through array
concatenation or the `array_merge()` PHP function. This form of merging has become intuitive for us; entries in the
first data set are overwritten by same-key entries in the to-be-merged data set(s). Because this algorithm has become 
intuition for us developers, we tend to unnecessarily accommodate it by pre-processing and/or sorting our data sets
prior to merging, in order to obtain the desired results. This can be avoided if the merging algorithm were to allow
the consumer to control its strategy. That is the purpose of this standard.

# Merge Strategies

Implementations of [`MergeStrategyInterface`] dictate how a single entry is merged into a subject data set. The below
demonstrates this by implementing the intuitive overwriting merging strategy:

```php
class OverwriteMergeStrategy implements MergeStrategyInterface
{
    public function mergeEntry($subject, $key, $value)
    {
        $subject[$key] = $value;

        return $subject;
    }
}
```

The strategy is free to check for key existence in the subject prior to manipulating it. The below demonstrates how
one may use different strategies according to the key:

```php
// Only overwrites if the key does not start with an exclamation mark
class CustomStrategy implements MergeStrategyInterface
{
    public function mergeEntry($subject, $key, $value)
    {
        if (strpos($key, '!') === 0 && array_key_exists(substr($key, 1), $subject)) {
            return $subject;
        }

        $subject[$key] = $value;

        return $subject;
    }
}
```

# Mergers

Mergers are objects that implement [`MergeCapableInterface`]. These objects represent the merging algorithm and can
accept a strategy for merging. Different implementations can use the strategy differently; one may use it solely for
resolving conflicting keys, another may use it in conjunction with its own internal strategy/strategies.

The below demonstrates a typical merging algorithm

```php
class Merger implements MergeCapableInterface
{
    public function merge($first, $second, MergeStrategyInterface $strategy)
    {
        $result = (array) $first;
        
        foreach ($second as $key => $value) {
            $result = $strategy->mergeEntry($result, $key, $value);
        }
        
        return $result;
    }
}
```

Implementations should not follow the above example and cast the arguments to `array`. Instead, consider using the
[`NormalizeArrayCapableTrait`] provided by the [`dhii/normalization-helper-base`] package, which can cast all of the
type of data sets into arrays.

[Dhii]: https://github.com/Dhii/dhii
[`MergeCapableInterface`]: src/MergeCapableInterface.php
[`MergeStrategyInterface`]: src/MergeStrategyInterface.php
[`NormalizeArrayCapableTrait`]: https://github.com/Dhii/normalization-helper-base/blob/develop/src/NormalizeArrayCapableTrait.php
[`dhii/normalization-helper-base`]: https://github.com/Dhii/normalization-helper-base
