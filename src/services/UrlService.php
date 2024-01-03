<?php

declare(strict_types=1);

namespace ShortUrl\Services;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UrlService
{
    public function shorten(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $response->getBody()->write("Hello world!");
        
        return $response;
    }

    public function redirect(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $response->getBody()->write("Hello world!");
        
        return $response;
    }

    private function convertIdToShortUrl(int $id): string
    {
        $map = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        $shortUrl = '';

        while ($id) {
            $shortUrl .= $map[$id % 62];
            $id = intval($id / 62);
        }

        $shortUrl = strrev($shortUrl);

        return $shortUrl;
    }
}