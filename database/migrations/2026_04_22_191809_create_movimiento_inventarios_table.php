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
        Schema::create('movimiento_inventarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_producto')->constrained('productos', 'id')->onDelete('cascade');
            $table->string('tipo_movimiento', 30); // compra, venta, ajuste_inicial, ajuste_positivo, ajuste_negativo
            $table->integer('cantidad');
            $table->unsignedBigInteger('referencia_id'); // ID de compra, venta o ajuste (sin FK por polimorfismo)
            $table->string('concepto', 255)->nullable();
            $table->timestamp('fecha_movimiento')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimiento_inventarios');
    }
};
