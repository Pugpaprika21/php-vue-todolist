<?php

require __DIR__ . '../../../includes/dependency.php';
require __DIR__ . '../../../controllers/todo/TodoController.php';

$todo = new TodoController($request);

echo $api->setResponseJSON($todo->addTask());