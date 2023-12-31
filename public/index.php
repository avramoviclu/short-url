<?php

use ShortUrl\Controllers\Api\V1\ShortenController;
use ShortUrl\Controllers\Api\V1\ShortUrlController;
use Slim\Routing\RouteCollectorProxy;
use DI\Bridge\Slim\Bridge;

require __DIR__ . '/../vendor/autoload.php';

$app = Bridge::create();

$app->group('/api/v1', function(RouteCollectorProxy $group) {

    $group->post('/shorten', ShortenController::class);

    $group->get('/short-url', ShortUrlController::class);
});

$app->run();