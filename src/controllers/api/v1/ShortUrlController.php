<?php

declare(strict_types=1);

namespace ShortUrl\Controllers\Api\V1;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ShortUrl\Services\UrlService;

final class ShortUrlController
{
    private UrlService $urlService;

    public function __construct(UrlService $urlService)
    {
        $this->urlService = $urlService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
    {
        $response = $this->urlService->shortUrl($request, $response, $args);
        
        return $response;
    }
}