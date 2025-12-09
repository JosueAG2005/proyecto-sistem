<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD

class Pedido extends Model
{
    protected $fillable = [
        'user_id',
        'total',
        'estado',
        'metodo_pago',
        'observaciones',
    ];

    protected $casts = [
        'total' => 'decimal:2',
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fecha_pedido',
        'total',
        'estado',
>>>>>>> 89fbe6a12fc20e76dae4ad5480f6d14c87d0ca7e
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detalles()
    {
<<<<<<< HEAD
        return $this->hasMany(PedidoDetalle::class);
=======
        return $this->hasMany(DetallePedido::class);
>>>>>>> 89fbe6a12fc20e76dae4ad5480f6d14c87d0ca7e
    }
}
