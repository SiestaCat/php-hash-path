<?php

namespace Siestacat\PhpHashPath\Exception;

/**
 * @package Siestacat\PhpHashPath\Exception
 */
class HashTooShortException extends \Exception
{
    public function __construct(string $hash, int $min_length)
    {
        parent::__construct(sprintf('The hash "%s" must be at least %d characters', $hash, $min_length));
    }
}