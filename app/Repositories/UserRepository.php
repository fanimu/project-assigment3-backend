<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAll() : Object{
        $user = $this->user->get();
        return $user;
    }

    public function store($data) : Object{
        $dataBaru = new $this->user;
        $dataBaru->name = $data['name'];
        $dataBaru->email = $data['email'];
        $dataBaru->password =  Hash::make($data['password']);
        $dataBaru->save();

        return $dataBaru->fresh();
    }
}
