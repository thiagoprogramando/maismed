<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Unit;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller {
    
    public function app(Request $request) {

        $query = Schedule::orderBy('turn', 'asc');

        if(!empty($request->turn)) {
            $query->where('turn', $request->turn);
        }

        if (!empty($request->id_unit)) {
            $unit_start = Unit::where('id', $request->id_unit)->first();
            $query->where('id_unit', $request->id_unit);
        } else {
            $unit_start = Unit::whereNotNull('name')->first();
            $unit_start != null ? $query->where('id_unit', $unit_start->id) : '';
        }

        if (Auth::user()->type == 3) {
            $query->where('id_user', Auth::user()->id);
        } elseif (!empty($request->id_user)) {
            $query->where('id_user', $request->id_user);
        }

        $events = $query->get();
        
        return view('app.app', [
            'events'     => $events,
            'users'      => User::where('type', 3)->get(),
            'units'      => Unit::all(),
            'unit_start' => $unit_start,
        ]);
    }
}
