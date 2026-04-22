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
        Schema::create('detalle_ajustes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_ajuste')->constrained('ajuste_inventarios', 'id')->onDelete('cascade');
            $table->foreignId('id_producto')->constrained('productos', 'id');
            $table->integer('cantidad');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_ajustes');
    }
};
