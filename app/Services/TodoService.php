<?php

namespace App\Services;

use App\Repositories\TodoRepository;
use Exception;
use MongoDB\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TodoService {
    protected $todoRepository;

    public function __construct(TodoRepository $todoRepository){
        $this->todoRepository = $todoRepository;
    }

    public function getAll(){
        $todo = $this->todoRepository->getAll();

        return $todo;
    }

    public function store($data) : Object {
        $validator = Validator::make($data, [
            'title' => 'required',
            'description' => 'required',
            'due_date' => 'required', 
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $result = $this->todoRepository->store($data);
        return $result;
    }

    public function getById($id)
    {
        try {
            $todo = $this->todoRepository->find($id);
            
            if ($todo) {
                return $todo;
            } else {
                return response()->json(['message' => 'ID Todo tidak ditemukan'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'ID Todo tidak valid'], 400);
        }
    }

    public function deleteById($id)
    {
        $result = $this->todoRepository->delete($id);

        if ($result) {
            return response()->json(['message' => 'Data berhasil dihapus'], 200);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan atau terjadi kesalahan'], 404);
        }
    }

    public function updateById($id, $data){
        $rules = [
            'title' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|in:completed,pending',
        ];
    
        $validator = Validator::make($data, $rules);
    
        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        try {
            // Cari Todo berdasarkan ID.
            $todo = $this->todoRepository->find($id);
    
            if ($todo) {
                $todo->update($data);
                return $todo;
            } else {
                return null;
            }
        } catch (Exception $e) {
            throw new Exception('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function getTodosWithPaginationAndSearch($perPage, $search)
    {
        $query = $this->todoRepository->query();
    
        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }
    
        $todos = $query->paginate($perPage);
    
        return $todos;
    }
}