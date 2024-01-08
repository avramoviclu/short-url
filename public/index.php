<?php

use ShortUrl\Controllers\Api\V1\ShortenController;
use ShortUrl\Controllers\Api\V1\RedirectController;
use ShortUrl\Database\RedisConnection;
use ShortUrl\Middleware\IpRateLimiterMiddleware;
use ShortUrl\Middleware\ShortenValidationMiddleware;
use Slim\Routing\RouteCollectorProxy;
use DI\Bridge\Slim\Bridge;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');

$dotenv->load();

$app = Bridge::create();

$dependencies = require __DIR__ . '/../src/config/dependencies.php';

$dependencies($app);

$app->group('/api/v1', function(RouteCollectorProxy $group) {

    $group->post('/shorten', ShortenController::class)
        ->add(new IpRateLimiterMiddleware())
        ->add(new ShortenValidationMiddleware());

    $group->get('/{short-url}', RedirectController::class);
});

$app->run();