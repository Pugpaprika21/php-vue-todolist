<?php

require __DIR__ . '../../../includes/dependency.php';
require __DIR__ . '../../../controllers/todo/TodoController.php';

$api->setMethodAllowed('GET');
$api->setAuthorization();

$todo = new TodoController($request);

write_log($apps['log']['req'] . TodoController::class . ".txt", $request, $env['WRITE_LOG']);
echo $api->setResponseJSON($todo->todoAll());