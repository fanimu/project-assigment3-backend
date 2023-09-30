<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TodoService;
use Exception;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    protected $todoService;
    
    public function __construct(TodoService $todoService){
        $this->todoService = $todoService;
    }

    public function getTodoList(){
        try {
            $result = $this->todoService->getAll();
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($result);
    }

    public function addTodo(Request $request){
        $data = $request->all();

        $result = ['status' => 201];

        try {
            $result['data'] = $this->todoService->store($data);
        } catch (Exception $e) {
            $result = [
                'status' => 422,
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function getTodoById($id)
    {
        try {
            $result = $this->todoService->getById($id);
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
            ];
        }
        return response()->json($result);
    }

    public function delTodoById($id)
    {
        try {
            $response = $this->todoService->deleteById($id);
            return $response;
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function updateTodo(Request $request, $id)
    {
        $data = $request->all();

        try {
            $updatedTodo = $this->todoService->updateById($id, $data);

            if ($updatedTodo) {
                return response()->json(['message' => 'Todo berhasil diupdate', 'data' => $updatedTodo], 200);
            } else {
                return response()->json(['message' => 'ID Todo tidak ditemukan'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function index(Request $request)
    {
        $user = Auth::user(); 
        $perPage = $request->query('per_page', 10); // Jumlah item per halaman, default 10.
        $search = $request->query('search', ''); // Kata kunci pencarian.

        $query = $this->todoService->getTodosWithPaginationAndSearch($perPage, $search);

        return response()->json(['todos' => $query, 'user' => $user], 200);
    }

   
}
