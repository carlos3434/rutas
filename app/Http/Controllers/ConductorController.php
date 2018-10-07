<?php

namespace App\Http\Controllers;
use Illuminate\Support\Collection;

use App\Conductor;
use App\Ruta;
use Illuminate\Http\Request;

class ConductorController extends Controller
{

    public function listConductores(Request $request, $id)
    {
        $query = Conductor::where('ruta_id',$id);
        if ($request->has('dir')) {
            $column = $request->input('column');
            $sortDir = $request->input('dir');
            $query = $query->orderBy($column, $sortDir);
        } else {
            $query = $query->orderBy('id', 'asc');
        }
        if ($request->has('nombre') && $request->input('nombre') <>'') { 
            $query->where('nombre', 'like', '%'.$request->input('nombre').'%');
        }
        if ($request->has('documento') && $request->input('documento') <>'') { 
            $query->where('documento', 'like', '%'.$request->input('documento').'%');
        }
        $perPage = $request->has('per_page') ? (int) $request->input('per_page') : null;
        $rutas = $query->paginate( $perPage );
        $data = $rutas->toArray();
        $col = new Collection([
            'recordsTotal'=>$rutas->total(),
            'recordsFiltered'=>$rutas->total()
        ]);
        return $col->merge($data);
    }
    public function showAllConductores()
    {
        return response()->json(Conductor::with('ruta')->get() );
    }

    public function showOneConductor($id)
    {
        return response()->json(Conductor::find($id)->with('ruta')->get());
    }

    public function create(Request $request, $id)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'documento' => 'required'
        ]);

        $ruta = Ruta::find(1);

        $conductor = $ruta->conductores()->saveMany([
            new Conductor($request->all())
        ]);

        return response()->json($conductor, 201);
    }

    public function update($id, Request $request)
    {
        $conductor = Conductor::findOrFail($id);
        $conductor->update($request->all());

        return response()->json($conductor, 200);
    }

    public function delete($id)
    {
        Conductor::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}