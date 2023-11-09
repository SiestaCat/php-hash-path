<?php

namespace Siestacat\Phpfilemanager\Tests\File;
use PHPUnit\Framework\TestCase;
use Siestacat\PhpHashPath\GenHashPath;

class GenHashPathTest extends TestCase
{
    public function test():void
    {
        $hash = 'aabbcc';

        $path = $this->_test(2,2, true, null, $hash);

        //Path array should be: [aa,bb,aabbcc]

        $path = $this->_test(2,2, false, null, $hash);

        //Path array should be: [aa,bb]

        $this->_test(2,2, false, 'md5');
    }

    public function test_getPathFileSystem()
    {

        $hash = 'aabbcc';

        $instance = new GenHashPath(2, 2);
        $path = $instance->getPathFileSystem($hash, true);
        $this->assertEquals
        (
            'aa' . DIRECTORY_SEPARATOR . 'bb' . DIRECTORY_SEPARATOR . $hash,
            $path
        );
    }

    private function assertPathIndex(array $path, int $index, int $length, string $value_expected):void
    {

        $path_index_value = $path[$index];

        fwrite(STDERR, sprintf('Check if path index %d have length %d and value is equal to "%s". Current path index value: "%s" Current path: "%s"', $index, $length, $value_expected, $path_index_value, json_encode($path)) . "\n");

        $this->assertEquals($value_expected, $path_index_value);
        $this->assertEquals(strlen($path_index_value), $length);
    }

    private function _test(int $path_length, int $paths_limit, bool $append_hash_at_path, ?string $hash_algo, ?string $hash = null):array
    {
        $instance = new GenHashPath($path_length, $paths_limit);

        //If hash arg is null generate random one
        $hash = $hash === null ? hash($hash_algo, random_bytes(512)) : $hash;

        $path = $instance->getPath($hash, $append_hash_at_path);

        $path_count = count($path);

        //Assert each path element
        foreach($path as $path_index => $path_index_value)
        {
            //Dont assert last path element if $append_hash_at_path is true
            if($append_hash_at_path && $path_index === ($path_count - 1)) continue;
            $this->assertPathIndex($path, $path_index, $path_length, $path_index_value);
        }

        $path_count_expected = ($paths_limit + ($append_hash_at_path ? 1 : 0));

        fwrite(STDERR, sprintf('Path count %d expect to have count %d', $path_count, $path_count_expected) . "\n");

        $this->assertEquals($path_count_expected, count($path));

        if($append_hash_at_path)
        {
            $last_path_index = $path[count($path) - 1];

            fwrite(STDERR, sprintf('Check if hash "%s" equal to last path index "%s"', $hash, $last_path_index) . "\n");

            $this->assertEquals($last_path_index, $hash, 'Hash equal to last path index');
        }

        return $path;
    }
}