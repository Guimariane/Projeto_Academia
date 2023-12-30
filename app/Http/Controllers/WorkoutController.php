<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkoutController extends Controller
{
    public function store(Request $request){
        try {
            $data = $request->validate([
                'repetitions' => 'int|required',
                'weight' => 'numeric|required',
                'break_time' => 'int|required',
                'day' => 'required|in: SEGUNDA, TERCA, QUARTA, QUINTA, SEXTA, SABADO, DOMINGO',
                'observations' => 'string',
                'time' => 'int|required'

            ]);

            $user_id = $request->user()->id;

            if (!$user_id) {
                return response()->json(['message' => 'Usuario nao autenticado'], Response::HTTP_BAD_REQUEST);
            }

            $search = $request->input('exercise_id');

            $day = $request->input('day');

            $data_workouts = Workout::query()->where(['exercise_id', $search])->count();

            if($data_workouts !== 0) return $this->error("Você já cadastrou esse exercício nesse dia", Response::HTTP_CONFLICT);

            $workouts = Workout::create([
                'user_id' => $user_id,
                ...$data
            ]);

            return $workouts;

        } catch (\Exception $exception){
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
