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
            $table->bigIncrements('id');
            $table->timestamps();
            $table->softDeletes();

            $table->string('sku', 50)->unique();
            $table->string('nombre', 250);
            $table->string('descripcion_corta', 1000);
            $table->text('descripcion_larga');
            $table->decimal('precio_usd', 8, 2);
            $table->decimal('precio_mxn', 8, 2);
            $table->string('imagen', 200)->nullable();
            $table->integer('stock');
            $table->dateTime('fecha_vigencia');
            $table->boolean('activo')->default(false);
            $table->enum('categoria', ['alimentos_bebidas','deportes','salud', 'ropa']);
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
