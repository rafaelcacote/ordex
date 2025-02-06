<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Usuarios\StoreUsuarioRequest;
use App\Http\Requests\Usuarios\UpdateUsuarioRequest;

class UserController extends Controller
{
    // Listar usuários com filtros
    public function index(Request $request)
    {
        $query = User::query();

        // Filtro por nome
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        // Filtro por username
        if ($request->has('username')) {
            $query->where('username', 'like', '%' . $request->input('username') . '%');
        }

        $users = $query->where('status', 1)->paginate(10);

        return view('usuarios.index', compact('users'));
    }

    // Exibir formulário de criação
    public function create()
    {
        return view('usuarios.create');
    }

    // Salvar novo usuário
    public function store(StoreUsuarioRequest $request)
    {


        User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'status' => 1,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuário criado com sucesso!');
    }

    // Exibir formulário de edição
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('usuarios.edit', compact('user'));
    }

    // Atualizar usuário
    public function update(UpdateUsuarioRequest $request, $id)
    {

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => $request->input('password') ? bcrypt($request->input('password')) : $user->password,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    // Excluir (desativar) usuário
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 0]);

        return redirect()->route('usuarios.index')->with('success', 'Usuário excluido com sucesso!');
    }
}
