<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Traits\HttpResponses;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{

    use HttpResponses;


    // Função para puxar a lista de estudantes
    public function index(Request $request)
    {
        $user_id = $request->user();

        if (!$user_id) {
            return $this->response('Usuário não autenticado', Response::HTTP_UNAUTHORIZED);
        }

        $students = $user_id->students()->orderBy('name')->get();

        return $students;
    }

    // Função para cadastrar um estudante:
    public function store(Request $request)
    {
        try {
            $data = $request->all();

            $request->validate([
                'name' => 'string|required',
                'email' => 'string|required|unique:students',
                'date_birth' => 'required',
                'cpf' => 'string|required|max:14|unique:students',
                'cep' => 'string',
                'street' => 'string',
                'state' => 'string',
                'netghborhood' => 'string',
                'city' => 'string',
                'number' => 'string',
                'contact' => 'string|required|max:20'
            ]);

            $user_id = $request->user()->id;

            if (!$user_id) {
                return response()->json(['message' => 'Usuario nao autenticado'], Response::HTTP_BAD_REQUEST);
            }

            $student = Student::create([
                'user_id' => $user_id,
                ...$data
            ]);

            return $student;
        } catch (Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    // Função para atualizar algum dado de um estudante:
    public function update($id, Request $request)
    {
        try {
            $request->validate([
                'name' => 'string|max:255',
                'email' => 'string|unique:students|max:255',
                'date_birth' => 'string',
                'cpf' => 'string|unique:students',
                'cep' => 'string',
                'street' => 'string',
                'state' => 'string',
                'netghborhood' => 'string',
                'city' => 'string',
                'number' => 'string',
                'contact' => 'string|max:20'
            ]);

            $students = Student::find($id);

            if (!$students) return $this->error("Estudante não encontrado. Tente novamente", Response::HTTP_NOT_FOUND);

            if ($students->user_id !== auth()->user()->id) {
                return $this->response('Você não tem permissão para atualizar este estudante', Response::HTTP_FORBIDDEN);
            }

            $students->update($request->all());

            return $students;
        } catch (\Exception $exception) {

            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    // Função para deletar (soft) um estudante:
    public function destroy($id)
    {

        $students = Student::find($id);

        if (!$students) return $this->error("Informação não encontrada", Response::HTTP_NOT_FOUND);

        if ($students->user_id !== auth()->user()->id) {
            return $this->response('Você não tem permissão para excluir este estudante', Response::HTTP_FORBIDDEN);
        }

        $students->delete();

        return $this->response("Informação excluída com sucesso", Response::HTTP_NO_CONTENT);
    }

    // Função para puxar somente um estudante em questão
    public function show(Request $request)
    {
        $search = $request->input('id');

        $students = Student::query()
            ->with('students')
            ->whereHas('students', function ($query) use ($search) {
                $query
                    ->select()
                    ->where('id', $search);
            })
            ->get();

        if (!$students) return $this->error("Estudante não encontrado. Tente novamente", Response::HTTP_NOT_FOUND);

        return $students;
    }
}
