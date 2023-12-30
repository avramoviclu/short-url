<?php

use ShortUrl\Controllers\Api\V1\ShortenController;
use ShortUrl\Controllers\Api\V1\ShortUrlController;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->group('/api/v1', function(RouteCollectorProxy $group) {

    $group->post('/shorten', ShortenController::class);

    $group->get('/short-url', ShortUrlController::class);
});


$app->run();