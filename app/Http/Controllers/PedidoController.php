<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        $query = Pedido::with('user');

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $pedidos = $query->orderBy('fecha_pedido', 'desc')->paginate(15);

        // ANTES: view('admin.pedidos.index')
        return view('pedidos.index', compact('pedidos'));
    }

    public function show(Pedido $pedido)
    {
        $pedido->load(['user', 'detalles.organico']);

        // ANTES: view('admin.pedidos.show')
        return view('pedidos.show', compact('pedido'));
    }
}
