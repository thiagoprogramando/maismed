<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

    public function profile() {

        return view('app.User.profile');
    }
    
    public function list(Request $request) {

        $query = User::orderBy('name', 'desc');

        if (!empty($request->name)) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if (!empty($request->crm)) {
            $query->where('crm', 'like', '%' . $request->crm . '%');
        }

        if (!empty($request->email)) {
            $query->where('email', $request->email);
        }

        $users = $query->get();
        return view('app.User.list', ['users' => $users]);
    }

    public function create(Request $request) {

        $user = new User();
        $user->name      = $request->name;
        $user->cpfcnpj   = $request->cpfcnpj;
        $user->email     = $request->email;
        $user->crm       = $request->crm;
        $user->type      = $request->type;
        $user->password  = bcrypt('123456');

        if($user->save()) {
            return redirect()->back()->with('success', 'Usuário cadastrado com sucesso!');
        }

        return redirect()->back()->with('error', 'Houve um problema, tente novamente mais tarde!');
    }

    public function update(Request $request) { 
        
        if(!empty($request->name)) {
            $data['name'] = $request->name;
        }

        if(!empty($request->cpfcnpj)) {
            $data['cpfcnpj'] = $request->cpfcnpj;
        }

        if(!empty($request->email)) {
            $data['email'] = $request->email;
        }

        if(!empty($request->crm)) {
            $data['crm'] = $request->crm;
        }

        if(!empty($request->type)) {
            $data['type'] = $request->type;
        }

        if(!empty($request->password)) {
            $data['password'] = bcrypt($request->password);
        }

        $user = User::where('id', Auth::id())->update($data);
        if($user) {
            return redirect()->back()->with('success', 'Dados atualizados com sucesso!');
        }

        return redirect()->back()->with('error', 'Houve um problema, tente novamente mais tarde!');
    }

    public function delete(Request $request) {

        $user = User::find($request->id);
        if($user) {

            $user->delete();
            return redirect()->back()->with('success', 'Usuário excluído com sucesso!');
        }

        return redirect()->back()->with('error', 'Houve um problema, tente novamente mais tarde!');
    }

    public function search(Request $request) {

        $events     = Schedule::where('id', 'like', '%' . $request->search . '%')->orWhereHas('user', function ($query) use ($request) {$query->where('name', 'like', '%' . $request->search . '%');})->get();
        $units      = Unit::where('name', 'like', '%' . $request->search . '%')->get();
        $users      = User::where('name', 'like', '%' . $request->search . '%')->get();

        return view('app.User.search', [
            'search'    => $request->search,
            'events'    => $events,
            'units'     => $units,
            'users'     => $users
        ]);
    }
}
