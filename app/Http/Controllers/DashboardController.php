<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Plan;
use App\Models\Student;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    public function index(Request $request){

        try {

            $user_id = $request->user()->id;

            $type_plan = $request->user()->plan_id;

            $plan = Plan::find($type_plan);

            $registered_students = Student::where('user_id', $user_id)->count();
            $registered_exercises = Exercise::where('user_id', $user_id)->count();
            $description_plan = $plan->description;
            $count_plan = $plan->limit;

            return response()->json([
                'Estudantes cadastrados' => $registered_students,
                'Exercícios cadastrados' => $registered_exercises,
                'Plano do Usuário' => $description_plan,
                'Cadastros Restantes' => $count_plan-$registered_students
                ]);

        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), 400);
        }
    }

}
