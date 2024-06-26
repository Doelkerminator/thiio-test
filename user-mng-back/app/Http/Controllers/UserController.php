<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use aliirfaan\LaravelSimpleJwt\Services\JwtHelperService;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request, JwtHelperService $jwtService) {
        $credentials = $request -> all();
        if(Auth::attempt($credentials)) {
            $user = User::firstWhere('email', $credentials['email']);
            $payload = [
                'email' => $credentials['email'],
                'id' => $user -> id,
                'admin' => $user -> isAdmin
            ];
            
            $jwt = $jwtService -> createJwtToken($payload);
            $user -> update([
                'jwt' => $jwt
            ]);
            return response(['jwt' => $jwt], 200);
        }
        else {
            return response(['message' => 'Incorrect credentials'], 403);
        }
    }

    public function logout(Request $request) {
        $id = $request -> header('id');
        $user = User::find($id);
        $user -> update([
            'jwt' => null
        ]);
        Auth::logout();
        return response([], 204);
    }

    public function signup(Request $request) {
        $credentials = $request -> all();
        if(User::firstWhere('email', $credentials['email'])) {
            return response(['message' => 'Email already exists!'], 400);
        }
        else {
            User::create([
                'name' => $credentials['name'],
                'email' => $credentials['email'],
                'password' => Hash::make($credentials['password'])
            ]);
        }
        return response(['message' => 'User created successfully'], 204);
    }

    public function update(Request $request) {
        $id = $request -> header('id');
        $user = User::find($id);
        if($user) {
            $data = $request -> all();
            if(Hash::check($data['password'], $user -> password)) {
                $checkUsr = User::firstWhere('email', $data['email']);
                if($checkUsr != null && $checkUsr -> id != $id) {
                    return response(['message' => 'Email is already in use!'], 400);
                }
                else {
                    $user -> update([
                        'name' => $data['name'] ?? $user -> name,
                        'email' => $data['email'] ?? $user -> email,
                    ]);
                    return response([], 204);
                }
            }
            else {
                return response(['message' => 'Password is incorrect!'], 403);
            }
        }
        else {
            return response(['message' => 'Bad request'], 400);
        }
    }

    public function delete(Request $request) {
        $id = $request -> header('id');
        User::find($id) -> delete();
        return response(['message' => 'User deleted!'], 204);
    }

    public function session(Request $request) {
        $user = User::find($request -> header('id'));
        return response(['user' => [
            'id' => $user -> id,
            'name' => $user -> name,
            'email' => $user -> email,
            'admin' => $user -> isAdmin
        ]]);
    }


    //? Admin functions
    public function users(Request $request) {
        $users = User::all();
        return response(['users' => $users], 200);
    }

    public function drop(int $id) {
        User::find($id)->delete();
        return response(['message' => 'User deleted!'], 204);
    }

    public function edit(Request $request, int $id) {

    }
}
