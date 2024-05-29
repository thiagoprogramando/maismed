<?php

namespace App\Http\Controllers\Unit;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller {
    
    public function list(Request $request) {

        $query = Unit::orderBy('name', 'desc');

        if(!empty($request->name)) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if(!empty($request->city)) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if(!empty($request->state)) {
            $query->where('state', 'like', '%' . $request->state . '%');
        }

        $units = $query->get();
        return view('app.Unit.list', ['units' => $units]);
    }

    public function create(Request $request) {

        $unit           = new Unit();
        $unit->name     = $request->name;
        $unit->city     = $request->city;
        $unit->state    = $request->state;

        if($unit->save()) {
            return redirect()->back()->with('success', 'Unidade cadastrada com sucesso!');
        }

        return redirect()->back()->with('error', 'Houve um problema, tente novamente mais tarde!');
    }

    public function update(Request $request) {

        $data = [
            'name'  => $request->name,
            'city'  => $request->city,
            'state' => $request->state,
        ];

        if(Unit::where('id', $request->id)->update($data)) {
            return redirect()->back()->with('success', 'Dados atualizados com sucesso!');
        }

        return redirect()->back()->with('error', 'Houve um problema, tente novamente mais tarde!');
    }

    public function delete(Request $request) {

        $unit = Unit::find($request->id);
        if($unit &&  $unit->delete()) {
            return redirect()->back()->with('success', 'Unidade excluída com sucesso!');
        }

        return redirect()->back()->with('error', 'Houve um problema, tente novamente mais tarde!');
    }
}
