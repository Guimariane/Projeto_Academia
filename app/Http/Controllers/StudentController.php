<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Traits\HttpResponses;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{

    use HttpResponses;


    // Função para puxar a lista de estudantes
    public function index() {
        try{

            $students = Student::findAll();

            return $students;

        } catch (\Exception $exception){
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }}


    // Função para cadastrar um estudante:
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

            return $students;

        } catch (\Exception $exception){

            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }

    // Função para atualizar algum dado de um estudante:
    public function update($id, Request $request){
        try{
            $data = $request->all();

            $request->validate([
                'name' => 'string|max: 255',
                'email'=> 'string|max: 255',
                'date_birth'=> 'date format: yyyy-mm-dd',
                'cpf'=> 'string|unique:students|',
                'contact'=> 'string',
                'cep'=> 'string|max: 20',
                'street'=> 'string',
                'state' => 'string',
                'neighborhood' => 'string',
                'city' => 'string',
                'number' => 'string'
            ]);

            $students = Student::find($id);

            if(!$students) return $this->error("Estudante não encontrado. Tente novamente", Response::HTTP_NOT_FOUND);

            $students->update($data);

            return $students;

        } catch (\Exception $exception) {

            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

    }

    // Função para deletar (soft) um estudante:
    public function destroy($id){
        $students = Student::find($id);

        if(!$students) return $this->error("Informação não encontrada", Response::HTTP_NOT_FOUND);

        $students->delete();

        return $this->response("Informação excluída com sucesso",Response::HTTP_NO_CONTENT);
        }

    // Função para puxar somente um estudante em questão
    public function show(Request $request) {
        $search = $request->input('id');

        $students = Student::query()
            ->with('students')
            ->whereHas('students', function ($query) use ($search) {
                $query
                    ->select()
                    ->where('id' == $search);
            })
            ->get();

        if(!$students) return $this->error("Estudante não encontrado. Tente novamente", Response::HTTP_NOT_FOUND);

        return $students;
    }
}
