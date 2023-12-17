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
        $todo->status = conText($body['status']); // ยังไม่เริ่ม // กำลังทำ // เสร็จแล้ว
        R::store($todo);
        R::close();

        if ($todo->id) {
            return ['msg' => 'เพิ่มข้อมูลสำเร็จ', 'status' => 201];
        }
        return ['msg' => 'เพิ่มข้อมูลสำเร็จ', 'status' => 204];
    }

    public function updateTaskStatus(): array
    {
        $body = $this->request['QueryString'];

        $taskId = conText($body['taskId']);
        $task = $this->rbf->findOne('todos', 'id = ?', [$taskId]);
        R::close();

        return ['task' => $task];
    }

    public function todoAll(): array
    {
        $todos = R::getAll("SELECT * FROM todos ORDER BY due_date DESC");
        R::close();
        return ['todos' => $todos];
    }
}
