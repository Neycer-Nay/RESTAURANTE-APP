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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_producto', 150);
            $table->text('descripcion')->nullable();
            $table->decimal('precio_venta', 10, 2);
            $table->decimal('margen_ganancia', 10, 2);
            $table->decimal('precio_compra', 10, 2);
            $table->enum('tipo_producto', ['almacenable', 'elaborado']);
            $table->foreignId('id_categoria')->nullable()->constrained('categorias', 'id')->nullOnDelete();
            $table->foreignId('id_marca')->nullable()->constrained('marcas', 'id')->nullOnDelete();
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
