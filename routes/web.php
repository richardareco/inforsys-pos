<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Cliente;
use Illuminate\Support\Str;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/clientes/crear', [ClienteController::class, 'create'])->name('clientes.create');
Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
Route::get('/pedidos/crear', [PedidoController::class, 'create'])->name('pedidos.create');
Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');




Route::get('/clientes', function () {
    $clientes = Cliente::orderBy('custname')->get();
    return view('clientes.index', compact('clientes'));
});

Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
Route::get('/clientes/{nro}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
Route::put('/clientes/{nro}', [ClienteController::class, 'update'])->name('clientes.update');





// Endpoint para buscar productos por nombre o código
Route::get('/buscar-item', [PedidoController::class, 'buscarItem'])->name('buscar.item');
use App\Models\Invo1;

Route::get('/pedidos/listado', function (Request $request) {
    $desde = $request->input('desde', Carbon::today()->format('Y-m-d'));
    $hasta = $request->input('hasta', Carbon::today()->format('Y-m-d'));

    $pedidos = \App\Models\Invo1::whereBetween('fecha', [$desde, $hasta])
                ->orderBy('fecha', 'desc')
                ->get();

    return view('pedidos.index', compact('pedidos', 'desde', 'hasta'));
})->name('pedidos.index');



Route::get('/buscar-cliente', function (\Illuminate\Http\Request $request) {
    $q = $request->get('q');
    return Cliente::where('custname', 'like', "%$q%")
        ->orWhere('ruc', 'like', "%$q%")
        ->limit(10)
        ->get(['custnr', 'custname']);
});





use Illuminate\Support\Facades\Log;


Route::post('/clientes/crear-desde-pedido', function (Request $request) {
    // 🧪 LOG de lo que está llegando
    Log::info('Datos recibidos', $request->all());

    try {
        $cliente = Cliente::create([
            'custname' => $request->custname,
            'ruc' => $request->ruc,
            'telef1' => $request->telef1,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud
        ]);

        Log::info('Cliente creado', ['id' => $cliente->id]);

        return response()->json([
                'custname' => $cliente->custname,
                'custnr' => $cliente->custnr, // <- generado por la DB
                'nro'     => $cliente->nro    // <- autoincremental
        ]);
    } catch (\Exception $e) {
        Log::error('❌ Error al crear cliente: ' . $e->getMessage());
        return response()->json(['error' => 'Error al guardar cliente'], 500);
    }
});

Route::get('/', function () {
    return view('menu');
})->name('menu');

Route::get('/home', function () {
    return view('home');
})->name('home');











