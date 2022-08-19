<?php

namespace App\Http\Controllers\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Controllers\Controller;
Use App\Services\UserService;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function create(){
        return view('auth.login');
    }

    public function store(LoginRequest $request){
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $userRole = auth()->user()->role;
            return redirect(UserService::getDashboardRouteBasedOnUserRole($userRole));

        } 
        return redirect()->route('auth.login.create')->with('warning', 'Autenticação falhou.')->withInput();
    }

    public function destroy(){
        Auth::logout();
        return redirect()->route('auth.login.create');
    }
}
