<?php

namespace App\Http\Controllers;
use App\Models\Cliente;
use Illuminate\Http\Request;


class ClienteController extends Controller
{
   public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
           // 'custnr'    => 'required|string|max:20|unique:cliente,custnr',
            'custname'  => 'required|string|max:100',
            'telef1'    => 'nullable|string|max:20',
            'latitud'   => 'nullable|numeric',
            'longitud'  => 'nullable|numeric',
            'ruc'       => 'nullable|string|max:20',
        ]);

        Cliente::create($validated);

        return redirect()->route('clientes.create')->with('success', 'Cliente guardado exitosamente.');
    } //

    public function edit($nro)
{
    $cliente = Cliente::findOrFail($nro);
    return view('clientes.edit', compact('cliente'));
}

public function update(Request $request, $nro)
{
    $cliente = Cliente::findOrFail($nro);

    $request->validate([
        'custname' => 'required|string|max:255',
        'ruc' => 'nullable|string|max:20',
        'telef1' => 'nullable|string|max:20',
        'latitud' => 'nullable|numeric',
        'longitud' => 'nullable|numeric',
    ]);

    $cliente->update([
        'custname' => $request->custname,
        'ruc' => $request->ruc,
        'telef1' => $request->telef1,
        'latitud' => $request->latitud,
        'longitud' => $request->longitud,
     ]);

        return redirect()->route('clientes.index')->with('success', '✅ Cliente actualizado correctamente.');
    }


public function index(Request $request)
{
    $query = Cliente::query();

    if ($request->filled('buscar')) {
        $buscar = $request->input('buscar');
        $query->where('custname', 'like', "%$buscar%")
              ->orWhere('ruc', 'like', "%$buscar%");
    }

    $clientes = $query->orderBy('custname')->get();
    return view('clientes.index', compact('clientes'));
}


}




