<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Traits\HttpResponses;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{

    use HttpResponses;

    public function index (Request $request) {
        try {
            $filters = $request->query();

            $students = Student::query()
                ->select(
                    'name',
                    'cpf',
                    'email'
                );


        }

    }
    public function store(Request $request) {
        try {
            $data = $request->all();

            $request->validate([
                'name' => 'string|required|max: 255',
                'email'=> 'string|required|unique:students|max: 255',
                'date_birth'=> 'required',
                'cpf'=> 'string|required|unique:students',
                'contact'=> 'string|required',
                'cep'=> 'string|max: 20',
                'street'=> 'string',
                'state' => 'string',
                'neighborhood' => 'string',
                'city' => 'string',
                'number' => 'string'
            ]);

            $students = Student::create($data);

            $students;

            return $this->response('Cadastro criado com sucesso', 201);

        } catch (\Exception $exception){
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
