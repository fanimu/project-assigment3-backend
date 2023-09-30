<?php

namespace App\Services;


use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;
use MongoDB\Exception\InvalidArgumentException;



class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    public function getAll(){
        $user = $this->userRepository->getAll();

        return $user;
    }

    public function store($data) : Object {
        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required', 
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $result = $this->userRepository->store($data);
        return $result;
    }
}
