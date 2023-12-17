<?php

ini_set('log_errors', 'on');
ini_set('display_errors', 'off');
ini_set('error_reporting', E_ALL);

date_default_timezone_set('Asia/Bangkok');

$env = parse_ini_file(__DIR__ . "../../.env");

$utils = __DIR__  . "../../utils/";
require(__DIR__ . "../../configs/app.php");
require("{$utils}functions/helpers.php");
require("{$utils}classes/RB.php");
require("{$utils}classes/APIService.php");

# {Redbean}

if (!empty($env['DB_NAME'])) {
    R::setup($env['DB_CONNECT_DNS'], $env['DB_USERNAME'], '');
    R::debug(false);
}

if (!empty($env['CLASS_API']) && $env['CLASS_API'] == true) {
    $api = new APIService($env);
    $request = $api->getRequest();
}

if (!empty($env['CORS']) && $env['CORS'] == true) {
    foreach ($apps['cors'] as $cors) {
        header($cors);
    }
}
