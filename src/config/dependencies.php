<?php

use Predis\Client;
use Slim\App;

return function (App $app) {
    
    $container = $app->getContainer();

    $container->set('db', function ($container) {
        
        $settings = $container->get('settings')['db'];
        
        $pdo = new PDO('mysql:host=' . $settings['host'] . ';dbname=' . $settings['name'],
            $settings['username'], $settings['password']);
        
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        return $pdo;
    });

    $container->set('redis', function ($container) {

        $settings = $container->get('settings')['redis'];

        $redis = new Client([
            'scheme' => $settings['scheme'],
            'host'   => $settings['host'],
            'port'   => $settings['port'],
        ]);

        return $redis;
    });
};