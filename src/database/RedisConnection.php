<?php

declare(strict_types=1);

namespace ShortUrl\Database;

use Predis\Client;

class RedisConnection
{  
    private static $instance;

    private string $host;
   
    private string $scheme;
   
    private string $port;

    public function __construct()
    {
        $this->host = $_ENV['REDIS_HOST'];

        $this->scheme = $_ENV['REDIS_SCHEME'];

        $this->port = $_ENV['REDIS_PORT'];
    }

    public static function getInstance(): self
    {
        if (! self::$instance) {

            self::$instance = new self();

        }

        return self::$instance;
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
