<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cliente;
use App\Models\Item;
use App\Models\Invo1;
use App\Models\Invo2;

class PedidoController extends Controller
{
    /**
     * Mostrar formulario de creación de pedido
     */
    public function create()
    {
        $clientes = Cliente::orderBy('custname')->get();
        return view('pedidos.create', compact('clientes'));
    }

    /**
     * Buscar producto por código o descripción (AJAX)
     */
    public function buscarItem(Request $request)
    {
        $query = $request->get('q');

        $items = Item::where('item', 'LIKE', "%$query%")
                    ->orWhere('descr', 'LIKE', "%$query%")
                    ->limit(10)
                    ->get();

        return response()->json($items);
    }

    /**
     * Guardar pedido en invo1 (cabecera) e invo2 (detalle)
     */
    public function store(Request $request)
    {
        $request->validate([
            'custnr' => 'required|string',
            'items'  => 'required|string' // JSON recibido desde el form
        ]);

        $items = json_decode($request->input('items'), true);

        if (empty($items)) {
            return back()->withErrors('Debes agregar al menos un producto.');
        }

        try {
            DB::beginTransaction();

            $sta_invnr = 'POS' . now()->format('YmdHis') . rand(10, 99);
            $fecha = now();
            $total = 0;
            $costoTotal = 0;

            foreach ($items as $item) {
                $subtotal = $item['qty'] * $item['precio'];
                $total += $subtotal;
                $costoTotal += $item['qty'] * $item['costo'];
            }

            // Insertar en invo1
            Invo1::create([
              //  'invnr'     => $invnr,
                'sta_invnr' => $sta_invnr,
                'pernr'     => '001', // O reemplazar con auth()->user()->id
                'custnr'    => $request->custnr,
                'ctotal'    => $costoTotal,
                'total'     => $total,
                'fecha'     => $fecha,
                'obs'       => $request->input('obs'),
                'origen'    => 'POS',
                'facturar'  => false,
                'depo'      => 'D01',
                'flag'      => '1'
            ]);

            // Insertar en invo2
            foreach ($items as $item) {
                Invo2::create([
                  //  'invnr'    => $invnr,
                     'sta_invnr' => $sta_invnr,
                   'item'     => $item['item'],
                    'qty'      => $item['qty'],
                    'precio'   => $item['precio'],
                    'costo' => $item['costo'] ,
                    'fecha'    => $fecha,
                    'depo'     => 'D01',
                     'flag'    => '1',
                     'descr' => $item['descr']

                   
                ]);
            }

            DB::commit();
            return redirect()->route('pedidos.create')->with('success', '✅ Pedido registrado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('❌ Error al guardar el pedido: ' . $e->getMessage());
        }
    }
}


