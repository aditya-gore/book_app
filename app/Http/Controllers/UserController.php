<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Mockery\Undefined;

class UserController extends Controller
{
    function register(Request $req)
    {
        // if (Auth::attempt(['email' => $req->email])) {
        //     return response()->json(['message' => 'User already registered'], 400);
        // }
        $validation = Validator::make($req->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirmPassword' => 'required|same:password',
        ]);
        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        } else {
            $allData = $req->all();
            $allData['password'] = bcrypt($allData['password']);
            $user = User::create($allData);
            $resArr = [];
            $resArr['token'] = $user->createToken('api-application')->accessToken;
            $resArr['id'] = $user->id;

            return response()->json($resArr, 200);
        }
        // $user = new User;
        // $user->name = $req->input('name');
        // $user->email = $req->input('email');
        // $user->password = Auth::make($req->input('password'));
        // $user->save();
        // return $user;
    }

    function login(Request $req)
    {
        if (Auth::attempt([
            'email' => $req->email,
            'password' => $req->password
        ])) {
            $authUser = Auth::user();
            $user = User::find($authUser->id);
            $resArr = [];
            $resArr['token'] = $user->createToken('api-application')->accessToken;
            $resArr['id'] = $user->id;
            return response()->json($resArr, 200);
        } else {
            return response()->json(['message' => 'Unauthorized Access'], 400);
        }
        // $user = User::where('email', $req->email)->first();
        // if (!$user || !Auth::check($req->password, $user->password)) {
        //     return ["error" => "Email or password is incorrect"];
        // }
        // return $user;
    }

    function getUserById($id)
    {
        $result = User::find($id);
        if ($result) {
            return $result;
        } else {
            return null;
        }
    }

    function makeAdmin($email)
    {
        $result = User::where('email', $email)->first();
        if ($result) {
            $result->isAdmin = true;
            $result->save();
            return $result;
        } else {
            return 'User not forund';
        }
    }

    function deleteUser($id)
    {
        $result = User::where('id', $id)->delete();
        if ($result)
            return $result;
        else
            return response()->json(['status' => 404], 404);
    }

    function getAllUsers()
    {
        return User::all();
        // $userEmail = $req->input('email');
        // $userId = User::where('email', $userEmail)->first();
        // $user = User::find($userEmail);
        // return $userEmail;
        // if ($user->isAdmin) {
        // } else {
        //     return 'Not Authorised';
        // }
    }
}
