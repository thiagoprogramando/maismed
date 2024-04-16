<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Unit;
use App\Models\User;

use Illuminate\Http\Request;

class AppController extends Controller {
    
    public function app(Request $request) {

        $query = Schedule::orderBy('turn', 'desc');

        if(!empty($request->turn)) {
            $query->where('turn', $request->turn);
        }

        if(!empty($request->id_user)) {
            $query->where('id_user', $request->id_user);
        }

        if(!empty($request->id_unit)) {
            $query->where('id_unit', $request->id_unit);
        }

        $events = $query->get();
        
        return view('app.app', [
            'events' => $events,
            'users'  => User::all(),
            'units'  => Unit::all()
        ]);
    }
}
