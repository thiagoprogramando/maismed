<?php

namespace App\Http\Controllers\Event;

use App\Exports\ScheduleExport;
use App\Http\Controllers\Controller;

use App\Models\Schedule;
use App\Models\Unit;
use App\Models\User;

use Dompdf\Dompdf;
use Dompdf\Options;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EventController extends Controller {
    
    public function list(Request $request) {
        
        $query = Schedule::orderBy('date_schedule', 'desc');

        if(!empty($request->turn)) {
            $query->where('turn', $request->turn);
        }

        if(!empty($request->id_user)) {
            $query->where('id_user', $request->id_user);
        }

        if(!empty($request->id_unit)) {
            $query->where('id_unit', $request->id_unit);
        }

        $events = $query->orderBy('date_schedule', 'asc')->paginate(30);
        return view('app.Event.list', [
            'events' => $events,
            'users'  => User::where('type', 3)->get(),
            'units'  => Unit::all()
        ]);
    }

    public function viewEvent($id) {

        $event = Schedule::find($id);
        return view('app.Event.view', [
            'event' => $event,
            'users' => User::all(),
            'units' => Unit::all()
        ]);
    }   

    public function create(Request $request) {

        $event = Schedule::where('id_user', $request->id_user)->
                           where('date_schedule', $request->date_schedule)->
                           where('turn', $request->turn)->count();
        if($event > 0) {
            return redirect()->back()->with('error', 'Já existe um evento para essa data e usuário, análise os dados!');
        }

        $event = new Schedule();
        $event->date_schedule   = $request->date_schedule;
        $event->turn            = $request->turn;
        $event->id_user         = $request->id_user;
        $event->id_unit         = $request->id_unit;

        $date = Carbon::parse($request->date_schedule);
        $event->day     = $date->day;
        $event->month   = $date->month;
        $event->year    = $date->year;

        $event->observation  = $request->observation;
        $event->situation    = $request->situation;
        if($event->save()) {
            return redirect()->back()->with('success', 'Evento cadastrado com sucesso!');
        }

        return redirect()->back()->with('error', 'Houve um problema, tente novamente mais tarde!');
    }

    public function update(Request $request) {

        $data = [
            'date_schedule'  => $request->date_schedule,
            'turn'           => $request->turn,
            'id_user'        => $request->id_user,
            'id_unit'        => $request->id_unit,
            'observation'    => $request->observation,
            'situation'      => $request->situation,
        ];

        $date = Carbon::parse($request->date_schedule);
        $data['day']     = $date->day;
        $data['month']   = $date->month;
        $data['year']    = $date->year;

        $schedule = Schedule::where('id', $request->id)->update($data);
        if($schedule) {
            return redirect()->back()->with('success', 'Dados atualizados com sucesso!');
        }

        return redirect()->back()->with('error', 'Houve um problema, tente novamente mais tarde!');
    }

    public function delete(Request $request) {

        $schedule = Schedule::find($request->id);
        if($schedule) {

            $schedule->delete();
            return redirect()->back()->with('success', 'Evento excluído com sucesso!');
        }

        return redirect()->back()->with('error', 'Houve um problema, tente novamente mais tarde!');
    }

    public function addEvent(Request $request) {

        $event = Schedule::where('id_user', $request->id_user)->
                           where('date_schedule', $request->date_schedule)->
                           where('turn', $request->turn)->count();
        if($event > 0) {
            return response()->json(['message' => 'Já existe um evento para essa data e usuário, análise os dados!'], 500);
        }

        $event = new Schedule();
        $event->date_schedule   = $request->date_schedule;
        $event->turn            = $request->turn;
        $event->id_user         = $request->id_user;
        $event->id_unit         = $request->id_unit;

        $date = Carbon::parse($request->date_schedule);
        $event->day     = $date->day;
        $event->month   = $date->month;
        $event->year    = $date->year;

        $event->observation  = $request->observation;
        $event->situation    = $request->situation;
        if($event->save()) {
            return response()->json(['id' => $event->id], 200);
        }
        
        return response()->json(['message' => 'Erro ao cadastrar o evento'], 500);
    }

    public function delEvent(Request $request) {

        $schedule = Schedule::find($request->id);
        if($schedule && $schedule->delete()) {
            return true;
        }

        return false;
    }

    public function graphCalendar(Request $request) {
        
        $query = Schedule::with('user')->orderBy('date_schedule', 'desc');
    
        if (!empty($request->id_user)) {
            $query->where('id_user', $request->id_user);
        }
    
        if (!empty($request->id_unit)) {
            $query->where('id_unit', $request->id_unit);
        }

        if (!empty($request->month)) {
            $query->whereMonth('date_schedule', $request->month);
        }

        if (!empty($request->year)) {
            $query->whereYear('date_schedule', $request->year);
        }
        
        $query->whereMonth('date_schedule', now()->month);
    
        $events = $query->get()->map(function($event) {
            $event->user_first_name = $event->user->firstName();
            return $event;
        });
    
        $users = $events->pluck('user')->unique();
    
        return view('graph.calendar', [
            'events'    => $events, 
            'users'     => $users,
            'unit'      => !empty($request->id_unit) ? Unit::find($request->id_unit) : '',
        ]);
    }    
    
}
