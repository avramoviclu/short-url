<?php

declare(strict_types=1);

namespace ShortUrl\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class ShortenValidationMiddleware
{
    /**
     * @param  Request        $request PSR-7 request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $body = $request->getBody()->getContents();

        if (! empty($body)) {
            
            $jsonContent = json_decode($body, true);

            if (filter_var($jsonContent['longUrl'], FILTER_VALIDATE_URL, FILTER_FLAG_QUERY_REQUIRED)) {
                
                $request = $request->withAttribute('jsonContent', $jsonContent);

                $response = $handler->handle($request);

            } else {

                $response = new Response(400);

                $payload = json_encode(['message' => 'Invalid input.']);
                
                $response->getBody()->write($payload);

                $response = $response->withAddedHeader('Content-Type', 'application/json');
            }
        }

        return $response;
    }
}
