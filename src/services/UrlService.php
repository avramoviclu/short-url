<?php

declare(strict_types=1);

namespace ShortUrl\Services;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UrlService
{
    public function shortUrl(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $response->getBody()->write("Hello world!");
        
        return $response;
    }

    public function shorten(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $response->getBody()->write("Hello world!");
        
        return $response;
    }

    private function urlShortener(int $id): string
    {
        $timeSalt = (int)strrev((string)time());

        $number = $timeSalt . $id;
        
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        
        $base = 62;
        
        $result = '';

        while ($number > 0) {
            
            $remainder = $number % $base;
            
            $result = $characters[$remainder] . $result;
            
            $number = floor($number / $base);
        }

        $result = substr($result, 0, 7);

        return $result;
    }
}