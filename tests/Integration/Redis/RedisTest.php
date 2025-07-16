<?php

namespace App\Tests\Integration\Redis;

use PHPUnit\Framework\TestCase;
use Redis;

class RedisTest extends TestCase
{
    public function testRedisConnection()
    {
        $redis = new Redis();
        $redis->connect('redis', 6379);

        $key = 'phpunit:test';
        $value = 'connected';

        $redis->set($key, $value);
        $this->assertSame($value, $redis->get($key));

        $redis->del($key);
        $redis->close();
    }
}
