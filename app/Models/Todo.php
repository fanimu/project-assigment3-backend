<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Todo extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'todo';

    protected $fillable = ['title', 'description', 'due_date', 'status'];
}
