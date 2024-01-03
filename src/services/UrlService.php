<?php

declare(strict_types=1);

namespace ShortUrl\Services;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UrlService
{
    public function shorten(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $response->getBody()->write("Hello world!");
        
        return $response;
    }

    public function redirect(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $response->getBody()->write("Hello world!");
        
        return $response;
    }
}