<?php

namespace App\Http\Controllers;

use App\Mail\SendWelcomeEmail;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    use HttpResponses;

    public function store(Request $request){

        try{

            $data = $request->all();

            $request->validate([
                'name'=>'string|required|max:255',
                'email'=>'string|required|unique:users|max:255',
                'date_birth'=>'string|required',
                'cpf'=> 'string|required|unique:users|max:14',
                'password'=>'string|required|min:8|max:32',
                'plan_id' => 'int|required'
            ]);

            $user = User::create($data);

            Mail::to($user->email, $user->name)
                ->send(new SendWelcomeEmail($user->name));

            return $user;

        } catch(\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

    }

}
