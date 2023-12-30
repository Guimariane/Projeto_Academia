<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExerciseController extends Controller
{
    // Função para cadastrar um exercício
    public function store(Request $request) {
        try {
            $data = $request->validate([
                'description' => 'string|required|max: 255'
            ]);

            $user_id = $request->user()->id;

            if (!$user_id) {
                return response()->json(['message' => 'Usuario nao autenticado'], Response::HTTP_BAD_REQUEST);
            }

            $exercises = Exercise::create([
                'user_id' => $user_id,
                ...$data
            ]);

            $exercises = Exercise::create($request->all());

            return $exercises;

        } catch (\Exception $exception){
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    // Função para puxar a lista de exercícios que o usuário cadastrou
    public function index(Request $request) {

        $user_id = $request->user();

        if (!$user_id) {
            return $this->response('Usuário não autenticado', Response::HTTP_UNAUTHORIZED);
        }

        $exercises = $user_id->exercises()->orderBy('name')->get();

        return $exercises;
    }

    // Deletar um exercício que o usuário cadastrou

    public function destroy($id){

        $exercises = Exercise::find($id);

        if (!$exercises) return $this->error("Informação não encontrada", Response::HTTP_NOT_FOUND);

        if ($exercises->user_id !== auth()->user()->id) {
            return $this->response("Você não tem permissão para excluir este exercício", Response::HTTP_FORBIDDEN);
        }

        $count = Workout::query()->where('exercise_id', $id)->count();

        if($count !== 0) return $this->error("Existem treinos que usam esse exercício", Response::HTTP_CONFLICT);

        $exercises->delete();

        return $this->response("Exercício excluído com sucesso", Response::HTTP_NO_CONTENT);

    }
}
