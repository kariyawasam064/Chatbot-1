<?php
// config/broadcasting.php

return [

    'connections' => [
        'pusher' => [
            'driver' => 'pusher',
            'key' => env('8b8cd58f044da646b71a'), // This gets the value from .env file
            'secret' => env('afd874e19fdf029fe7dd'), // This gets the value from .env file
            'app_id' => env('1934173'), // This gets the value from .env file
            'cluster' => env('ap2'), // Default to 'mt1' if not set
            'use_tls' => true, // Ensure the connection is secure using TLS
        ],

        // You can add other broadcast drivers like Redis, etc., here if needed.
    ],
];
