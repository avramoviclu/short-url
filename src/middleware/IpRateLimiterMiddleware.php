<?php

declare(strict_types=1);

namespace ShortUrl\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Predis\Client;
use ShortUrl\Database\RedisConnection;
use Slim\App;

class IpRateLimiterMiddleware
{
    const MAX_CALLS_LIMIT = 3;
    
    const TIME_PERIOD = 10;

    private int $totalUserCalls = 0;

    private Client $redis;

    public function __construct()
    {
        $this->redis = RedisConnection::getInstance()->connect();
    }

    /**
     * @param  Request        $request PSR-7 request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);

        if ($_ENV['DISABLE_RATE_LIMITER']) {
            return $response;
        }

        if (! empty($_SERVER['HTTP_CLIENT_IP'])) {

            $userIpAddress = $_SERVER['HTTP_CLIENT_IP'];
        
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        
            $userIpAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        
        } else {
        
            $userIpAddress = $_SERVER['REMOTE_ADDR'];
        
        }
        
        if (! $this->redis->exists($userIpAddress)) {
            
            $this->redis->set($userIpAddress, 1);
            
            $this->redis->expire($userIpAddress, self::TIME_PERIOD);
            
            $this->totalUserCalls = 1;

        } else {
            
            $this->redis->INCR($userIpAddress);

            $this->totalUserCalls = (int) $this->redis->get($userIpAddress);
            
            if ($this->totalUserCalls > self::MAX_CALLS_LIMIT) {

                $response = new Response(429);

                $payload = json_encode(['message' => $userIpAddress . ' limit exceeded.']);
                
                $response->getBody()->write($payload);

                $response = $response->withAddedHeader('Content-Type', 'application/json');
            }
        }

        return $response;
    }
}
