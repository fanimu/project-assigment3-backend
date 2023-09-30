<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use Exception;


class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getTodoList(){
        try {
            $result = $this->userService->getAll();
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($result);
    }

    public function addUser(Request $request)
    {
        $data = $request->all();

        $result = ['status' => 201];

        try {
            $result['data'] = $this->userService->store($data);
        } catch (Exception $e) {
            $result = [
                'status' => 422,
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }
}
