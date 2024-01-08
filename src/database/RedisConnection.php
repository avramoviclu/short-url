<?php

declare(strict_types=1);

namespace ShortUrl\Database;

use Predis\Client;

class RedisConnection
{  
    private $host;
   
    private $scheme;
   
    private $port;

    public function __construct()
    {
        $this->host = $_ENV['REDIS_HOST'];

        $this->scheme = $_ENV['REDIS_SCHEME'];

        $this->port = $_ENV['REDIS_PORT'];
    }

    public function connect(): Client
    {
        $redis = new Client([
            'scheme' => $this->host,
            'host'   => $this->scheme,
            'port'   => $this->port
        ]);

        return $redis;
    }
}
