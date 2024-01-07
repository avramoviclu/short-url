<?php

return [
    'settings' => [
        'db' => [
            'host' => getenv('DB_HOST'),
            'name' => getenv('DB_USER'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD')
        ],
        'redis' => [
            'host' => getenv('REDIS_HOST'),
            'scheme' => getenv('REDIS_SCHEME'),
            'port' => getenv('REDIS_PORT')
        ]
    ],
];