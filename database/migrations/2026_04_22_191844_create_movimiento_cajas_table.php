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
        Schema::create('movimiento_cajas', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_movimiento', ['ingreso', 'salida'])->default('salida');
            $table->decimal('monto', 10, 2);
            $table->string('concepto', 255);
            $table->text('detalle')->nullable();
            $table->datetime('fecha_movimiento')->useCurrent();
            $table->foreignId('id_caja')->constrained('cajas', 'id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimiento_cajas');
    }
};
