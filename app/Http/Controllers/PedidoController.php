<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
<<<<<<< HEAD
use App\Models\PedidoDetalle;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

=======
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
>>>>>>> 89fbe6a12fc20e76dae4ad5480f6d14c87d0ca7e
        return view('pedidos.index', compact('pedidos'));
    }

    public function show(Pedido $pedido)
    {
<<<<<<< HEAD
        if ($pedido->user_id !== Auth::id()) {
            abort(403);
        }

        $pedido->load('detalles');

        return view('pedidos.show', compact('pedido'));
    }

    public function store(Request $request)
    {
        $userId = Auth::id();

        $cartItems = CartItem::where('user_id', $userId)
            ->with('ganado', 'maquinaria', 'organico')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        DB::beginTransaction();

        try {
            $total = $cartItems->sum('subtotal');

            $pedido = Pedido::create([
                'user_id' => $userId,
                'total'   => $total,
                'estado'  => 'pendiente',
            ]);

            foreach ($cartItems as $item) {
                $product = $item->product;

                PedidoDetalle::create([
                    'pedido_id'       => $pedido->id,
                    'product_id'      => $item->product_id,
                    'product_type'    => $item->product_type,
                    'nombre_producto' => $product ? $product->nombre : 'Producto eliminado',
                    'cantidad'        => $item->cantidad,
                    'precio_unitario' => $item->precio_unitario,
                    'subtotal'        => $item->subtotal,
                    'notas'           => $item->notas,
                ]);

                // (Opcional) descontar stock si quieres
                // if ($product && in_array($item->product_type, ['ganado', 'organico'])) {
                //     $product->stock = max(0, ($product->stock ?? 0) - $item->cantidad);
                //     $product->save();
                // }
            }

            CartItem::where('user_id', $userId)->delete();

            DB::commit();

            return redirect()
                ->route('pedidos.show', $pedido)
                ->with('success', 'Pedido creado correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'Ocurrió un error al crear el pedido.');
        }
    }
=======
        $pedido->load(['user', 'detalles.organico']);

        // ANTES: view('admin.pedidos.show')
        return view('pedidos.show', compact('pedido'));
    }
>>>>>>> 89fbe6a12fc20e76dae4ad5480f6d14c87d0ca7e
}
