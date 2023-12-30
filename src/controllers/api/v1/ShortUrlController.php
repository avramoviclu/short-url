<?php

declare(strict_types=1);

namespace ShortUrl\Controllers\Api\V1;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ShortUrlController
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $response->getBody()->write("Hello world!");
        
        return $response;
    }
}