<?php

namespace Siestacat\PhpHashPath;

use Siestacat\PhpHashPath\Exception\HashTooShortException;

/**
 * @package Siestacat\PhpHashPath
 */
class GenHashPath
{

    const PATH_LENGTH = 2;

    const PATHS_LIMIT = 2;

    public function __construct
    (
        private int $path_length = self::PATH_LENGTH,
        private int $paths_limit = self::PATHS_LIMIT
    )
    {}

    public function getPath(string $hash, bool $append_hash_at_path = true):array
    {
        $hash_min_length = $this->path_length + $this->paths_limit + 1;

        if(strlen($hash) < $hash_min_length) throw new HashTooShortException($hash, $hash_min_length);

        $path = [];

        while(count($path) < $this->paths_limit)
        {
            $path[] = substr
            (
                $hash,
                (count($path) * $this->path_length),
                $this->path_length
            );
        }

        if($append_hash_at_path) $path[] = $hash;

        return $path;
    }

    public function getPathFileSystem():string
    {
        return implode(DIRECTORY_SEPARATOR, call_user_func_array([$this, 'getPath'], func_get_args()));
    }
}