<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Workout;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkoutController extends Controller
{
    // Função para cadastro de treinos
    public function store(Request $request){
        try {
            $data = $request->validate([
                'student_id' => 'int|required',
                'exercise_id' => 'int|required',
                'repetitions' => 'int|required',
                'weight' => 'numeric|required',
                'break_time' => 'int|required',
                'day' => 'required|in:SEGUNDA,TERCA,QUARTA,QUINTA,SEXTA,SABADO,DOMINGO',
                'observations' => 'string',
                'time' => 'int|required'

            ]);

            $user_id = $request->user()->id;

            if (!$user_id) {
                return response()->json(['message' => 'Usuario nao autenticado'], Response::HTTP_BAD_REQUEST);
            }

            $student = $request->input('student_id');

            $exercise = $request->input('exercise_id');

            $day = $request->input('day');

            $data_workouts = Workout::query()
                    ->where(['student_id' => $student, 'exercise_id' => $exercise, 'day' => $day])
                    ->count();

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

    // Função para listagem de treinos
    public function index(Request $request, $id){
        $user = $request->user();

        $students = $user->students()->findOrFail($id);

        $student_name = $students->name;

        $workouts = Workout::where('student_id', $id)->get();

        $response = [
            'student_id' => $id,
            'student_name' => $student_name,
            'workouts' => [
                'SEGUNDA' => [],
                'TERCA' => [],
                'QUARTA' => [],
                'QUINTA' => [],
                'SEXTA' => [],
                'SABADO' => [],
                'DOMINGO' => [],
            ],
        ];

        foreach ($workouts as $workout) {
            $day = strtoupper($workout->day);
            $response['workouts'][$day][] = [
                'description' => $workout->exercises->description,
                'repetitions' => $workout->repetitions,
                'weight' => $workout->weight,
                'break_time' => $workout->break_time,
                'day' => $workout->day,
                'observations' => $workout->observations,
                'time' => $workout->time,
            ];
        }

        // apenas criar o pdf e passar a variável $students, $workouts e $response

        return response()->json($response, 200);
    }

    // Função para criar o pdf
    public function export (Request $request, $id){

        $user = $request->user();

        $students = $user->students()->findOrFail($id);

        $student_name = $students->name;

        $workouts = Workout::where('student_id', $id)->get();

        $response = [
            'student_id' => $id,
            'student_name' => $student_name,
            'workouts' => [
                'SEGUNDA' => [],
                'TERCA' => [],
                'QUARTA' => [],
                'QUINTA' => [],
                'SEXTA' => [],
                'SABADO' => [],
                'DOMINGO' => [],
            ],
        ];

        foreach ($workouts as $workout) {
            $day = strtoupper($workout->day);
            $response['workouts'][$day][] = [
                'description' => $workout->exercises->description,
                'repetitions' => $workout->repetitions,
                'weight' => $workout->weight,
                'break_time' => $workout->break_time,
                'day' => $workout->day,
                'observations' => $workout->observations,
                'time' => $workout->time,
            ];
        }

        $pdf = Pdf::loadView('pdf.treino', [
            'students' => $students,
            'workouts' => $workouts,
            'response' => $response
        ]);

        return $pdf->stream('treino.pdf');

    }
    }
