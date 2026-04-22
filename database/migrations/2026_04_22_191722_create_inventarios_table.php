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
        Schema::create('inventarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_producto')->constrained('productos', 'id')->onDelete('cascade');
            $table->integer('cantidad_actual')->default(0);
            $table->integer('cantidad_minima')->default(0);
            $table->integer('cantidad_maxima')->default(0);
            $table->timestamp('ultima_actualizacion')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventarios');
    }
};
