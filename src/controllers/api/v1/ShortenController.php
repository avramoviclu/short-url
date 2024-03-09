<?php

declare(strict_types=1);

namespace ShortUrl\Controllers\Api\V1;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ShortUrl\Services\UrlService;
use Slim\Psr7\Response;

final class ShortenController
{
    private UrlService $urlService;

    public function __construct(UrlService $urlService)
    {
        $this->urlService = $urlService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
    {
        $body = $request->getBody()->getContents();

        $jsonContent = json_decode($body, true);

        $shortUrl = $this->urlService->shorten($jsonContent['longUrl']);
        
        $response = new Response(200);

        $payload = json_encode(['shortenUrl' => $shortUrl]);
        
        $response->getBody()->write($payload);

        $response = $response->withAddedHeader('Content-Type', 'application/json');

        return $response;
    }
}