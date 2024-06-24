<?php

namespace App\Http\Controllers\Access;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {

    public function index() {

        $units = Unit::orderBy('name', 'asc')->get();

        return view('welcome', [
            'units' => $units
        ]);
    }
    
    public function login() {

        return view('login');
    }

    public function logon(Request $request) {

        $credentials = $request->only(['email', 'password']);
        $credentials['password'] = $credentials['password'];
        if (Auth::attempt($credentials)) {
            return redirect()->route('app');
        } else {
            return redirect()->back()->with('error', 'Credenciais inválidas!');
        }
    }

    public function logout() {
        
        Auth::logout();
        return redirect()->route('login');
    }

}
