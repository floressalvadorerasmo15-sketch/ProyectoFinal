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
    Schema::create('hospedajes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
        $table->string('nombre');
        $table->text('descripcion')->nullable();
        $table->string('direccion');
        $table->string('estado')->default('activo'); // activo, inactivo, pendiente
        $table->timestamps();
        $table->softDeletes();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospedajes');
    }
};
