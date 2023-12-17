<?php

$apps = [
    
    'cors' => [
        'Access-Control-Allow-Methods: *',
        'Access-Control-Allow-Headers: *',
        'Access-Control-Allow-Origin: *',
        'Content-type: application/json'
    ],

    'log' => [
        'req' => __DIR__ . "../../logs/requests/",
        'resp' => __DIR__ . "../../logs/response/"
    ],
];
