<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;

use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\DB;

use Mail;
use App\User;
use App\StoreUserRequest;
use Hash;

class UserControllerAPI extends Controller
{
    public function getUsers(Request $request)
    {
        if ($request->has('page')) {
            return UserResource::collection(User::paginate(5));
        } else {
            return UserResource::collection(User::all());
        }
    }

    public function getUser($id)
    {
        return new UserResource(User::find($id));
    }

/*
    public function store(Request $request)
    {
        $request->validate([
                'name' => 'required',
                'nickname' => 'required'
                'email' => 'required|email|unique:users,email',
                'password' => 'min:3'
            ]);
        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($user->password);
        $user->save();
        //mandar mail algures aqui
        return response()->json(new UserResource($user), 201);
    }
*/

    public function store(Request $request)
    {
        $request->validate([
                'name' => 'required',
                'nickname' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:3'
            ]);

        $confirmation_code = str_random(30);

        $user = User::create([
            'name' => $request->name,
            'nickname' => $request->nickname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'confirmation_code' => $confirmation_code
        ]);

        $data = [
            'confirmation_code' => $user->confirmation_code,
            'name' => $user->name
        ];

        Mail::send('emails.verify', $data, function($message) use($user) {
            $message->to($user->email, $user->nickname)->subject('BlackJack Registration');
        });

        return $confirmation_code;
    }

    public function verify($confirmation_code)
    {

        if(!$confirmation_code)
        {
            throw new InvalidConfirmationCodeException;
        }

        $user = User::where('confirmation_code', $confirmation_code)->first();

        if ( ! $user)
        {
            return view('errors.verificationError');
        }

        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

        return redirect('/#/login');

    }


    public function update(Request $request, $id)
    {
        $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.$id,
                'age' => 'integer|between:18,75'
            ]);
        $user = User::findOrFail($id);
        $user->update($request->all());
        return new UserResource($user);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }


    public function blockUser($id)
    {
        $user = User::findOrFail($id);
        ($user->blocked == 1) ? $user->blocked =0 : $user->blocked =1;   
        $user->save();
        return "User Blocked";
    }


    public function emailAvailable(Request $request)
    {
        $totalEmail = 1;
        if ($request->has('email') && $request->has('id')) {
            $totalEmail = DB::table('users')->where('email', '=', $request->email)->where('id', '<>', $request->id)->count();
        } else if ($request->has('email')) {
            $totalEmail = DB::table('users')->where('email', '=', $request->email)->count();
        }
        return response()->json($totalEmail == 0);
    }
}
