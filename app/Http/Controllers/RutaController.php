<?php

namespace App\Http\Controllers;
use Illuminate\Support\Collection;
use App\Ruta;
use App\Conductor;
use Illuminate\Http\Request;

class RutaController extends Controller
{

    public function showAllRutas()
    {
        return response()->json(Ruta::all());
    }

    public function listRutas(Request $request)
    {
        $query = Ruta::from('rutas');
        if ($request->has('dir')) {
            $column = $request->input('column');
            $sortDir = $request->input('dir');
            $query = $query->orderBy($column, $sortDir);
        } else {
            $query = $query->orderBy('id', 'asc');
        }
        if ($request->has('origen') && $request->input('origen') <>'') { 
            $query->where('origen', 'like', '%'.$request->input('origen').'%');
        }
        if ($request->has('destino') && $request->input('destino') <>'') { 
            $query->where('destino', 'like', '%'.$request->input('destino').'%');
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

    public function showOneRuta($id)
    {
        return response()->json( Ruta::with('conductores')->get() );
        return response()->json(Ruta::find($id));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'origen' => 'required',
            'destino' => 'required'
        ]);
        $ruta = Ruta::create($request->all());

        return response()->json($ruta, 201);
    }

    public function update($id, Request $request)
    {
        $ruta = Ruta::findOrFail($id);
        $ruta->update($request->all());

        return response()->json($ruta, 200);
    }

    public function delete($id)
    {
        Ruta::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}