<?php

use RedBeanPHP\Finder;

class TodoController
{
    private Finder $rbf;

    public function __construct(private array $request)
    {
        $this->rbf = new Finder(R::getToolBox());
        $this->request = $request;
    }

    public function addTask(): array
    {
        $body = $this->request['Ajax'];

        $todo = R::dispense('todos');
        $todo->task_name = conText($body['task_name']);
        $todo->due_date = conText($body['due_date']);
        $todo->status = conText($body['status']);
        $todo->status_num = conText($body['status_num']);

        R::store($todo);
        R::close();

        if ($todo->id) {
            return ['msg' => 'Create Task Success ..', 'status' => 201];
        }
        return ['msg' => 'Create Task Error ..', 'status' => 204];
    }

    public function updateTaskStatus(): array
    {
        $body = $this->request['QueryString'];

        $taskId = conText($body['taskId']);
        $statusNum = conText($body['statusNum']);

        if ($this->rbf->findOne('todos', 'id = ?', [$taskId])) {
            if ($statusNum == 1) {
                $status = 'In progress';
                $statusNum = 2;
            } else if ($statusNum == 2) {
                $status = 'Completed';
                $statusNum = 3;
            }
            $todo = R::load('todos', $taskId);
            $todo->status = $status;
            $todo->status_num = $statusNum;
            R::store($todo);
            R::close();
            return ['msg' => 'Update Status Success ..'];
        }

        return ['msg' => ''];
    }

    public function deleteTask(): array
    {
        $body = $this->request['QueryString'];

        $taskId = conText($body['taskId']);
        if (R::trash('todos', $taskId)) {
            R::close();
            return ['msg' => 'Delete Task Success ..'];
        }
        return ['msg' => 'Delete Task Error ..'];
    }

    public function todoAll(): array
    {
        $todos = R::getAll("SELECT * FROM todos ORDER BY due_date DESC");
        R::close();
        return ['todos' => $todos];
    }
}
