<?php

use ShortUrl\Controllers\Api\V1\ShortenController;
use ShortUrl\Controllers\Api\V1\ShortUrlController;
use Slim\Routing\RouteCollectorProxy;
use DI\Bridge\Slim\Bridge;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');

$dotenv->load();

$app = Bridge::create();

$dependencies = require __DIR__ . '/../src/config/dependencies.php';

$dependencies($app);

$app->group('/api/v1', function(RouteCollectorProxy $group) {

    $group->post('/shorten', ShortenController::class);

    $group->get('/short-url', ShortUrlController::class);
});

$app->run();