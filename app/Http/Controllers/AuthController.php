<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Exibe o formulário de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Processa o login
    public function login(Request $request)
    {
        // Valida os campos de entrada
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tenta autenticar o usuário
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Redireciona para o dashboard após o login
            return redirect()->intended('/dashboard');
        }

        // Retorna com erro se a autenticação falhar
        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ]);
    }

    // Processa o logout
    public function logout(Request $request)
    {
        Auth::logout(); // Faz o logout do usuário
        $request->session()->invalidate(); // Invalida a sessão
        $request->session()->regenerateToken(); // Gera um novo token CSRF
        return redirect('/'); // Redireciona para a página inicial
    }
}
