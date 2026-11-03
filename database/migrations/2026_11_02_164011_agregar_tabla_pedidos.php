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
            $table->bigIncrements('id');
            $table->timestamps();

            $table->string('folio', 25);
            $table->string('email', 255);
            $table->decimal('subtotal', 8, 2);
            $table->decimal('impuestos', 8, 2);
            $table->decimal('total', 8, 2);
            $table->enum('estatus', ['pendiente','pagado','cancelado']);
            $table->dateTime('fecha');
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
