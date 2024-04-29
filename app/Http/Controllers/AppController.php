<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Unit;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller {
    
    public function app(Request $request) {

        if(Auth::user()->type == 2) {
            return redirect()->route('list-user')->with('success', 'Acessando como supervisor!');
        }

        $query = Schedule::orderBy('turn', 'desc');

        if(!empty($request->turn)) {
            $query->where('turn', $request->turn);
        }

        if(!empty($request->id_unit)) {
            $query->where('id_unit', $request->id_unit);
        }

        if(Auth::user()->type != 1) {
            $query->where('id_user', Auth::user()->id);
        } elseif(!empty($request->id_user)) {
            $query->where('id_user', $request->id_user);
        }

        $events = $query->get();
        
        return view('app.app', [
            'events' => $events,
            'users'  => User::all(),
            'units'  => Unit::all()
        ]);
    }
}
