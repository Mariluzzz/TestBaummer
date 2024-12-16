<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create()
    {
        return view('users.createUser');
    }

    public function login()  {
        return view('users.loginUser');
    }

    public function register(RegisterUserRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.login')->with('success', 'Usuário cadastrado com sucesso!');
    }

    public function validate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/')->with('success', 'Usuário conectado');
        }

        return redirect()->route('user.login')->withErrors(['email' => 'As credenciais não correspondem.']);
    }

    public function destroy() {
        Auth::logout();
        return redirect()->route('home')->with('success', 'Usuário desconectado');
    }
}
