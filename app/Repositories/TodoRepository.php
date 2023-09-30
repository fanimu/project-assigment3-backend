<?php

namespace App\Repositories;

use App\Models\Todo;
use PhpParser\Node\Expr\Cast\Object_;

class TodoRepository
{
    protected $todo;
    public function __construct(Todo $todo){
        $this->todo = $todo;
    }

    public function getAll() : Object{
        $todo = $this->todo->get();
        return $todo;
    }

    public function store($data) : Object{
        $dataBaru = new $this->todo;
        $dataBaru->title = $data['title'];
        $dataBaru->description = $data['description'];
        $dataBaru->due_date = $data['due_date'];
        $dataBaru->status = $data['status'];
        $dataBaru->save();

        return $dataBaru->fresh();
    }

    public function find($id)
    {
        return $this->todo->find($id);
    }

    public function delete($id)
    {
        return $this->todo->destroy($id);
    }

    public function query()
    {
        return $this->todo->query();
    }



   
}