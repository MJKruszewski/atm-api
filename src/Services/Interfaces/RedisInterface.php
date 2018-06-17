<?php

namespace App\Services;


interface RedisInterface
{

    /**
     * @param string $key
     * @param string|int|float $value
     * @param int|null $expires
     */
    public function addCache(string $key, $value, int $expires = null): void;

    /**
     * @param string $key
     */
    public function removeCache(string $key): void;

    /**
     * @param string $key
     * @return string|null
     */
    public function readCache(string $key): ?string;

}