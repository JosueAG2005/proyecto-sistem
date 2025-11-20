<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();

            // Por ahora solo admin ve todo → user_id es opcional
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete(); 

            $table->dateTime('fecha_pedido')->useCurrent();
            $table->decimal('total', 10, 2)->default(0);

            // Estado del pedido
            $table->enum('estado', ['pendiente', 'pagado', 'cancelado'])
                  ->default('pendiente');

            $table->timestamps();

            // Índices para búsquedas eficientes
            $table->index(['user_id', 'estado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
