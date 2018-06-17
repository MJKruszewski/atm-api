<?php

namespace App\Services;


use SymfonyBundles\RedisBundle\Redis\ClientInterface;

final class RedisService implements RedisInterface
{

    /**
     * @var ClientInterface
     */
    private $redis;

    /**
     * RedisService constructor.
     * @param ClientInterface $redis
     */
    public function __construct(ClientInterface $redis)
    {
        $this->redis = $redis;
    }

    /**
     * @param string $key
     * @param float|int|string $value
     * @param int|null $expires
     */
    public function addCache(string $key, $value, int $expires = null): void
    {
        $this->redis->set($key, $value, 'ex', $expires);
    }

    /**
     * @param string $key
     */
    public function removeCache(string $key): void
    {
        $this->redis->remove($key);
    }

    /**
     * @param string $key
     * @return null|string
     */
    public function readCache(string $key): ?string
    {
        return $this->redis->get($key);
    }

    public function __destruct()
    {
        $this->redis->disconnect();
    }

}