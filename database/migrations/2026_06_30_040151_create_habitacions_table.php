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
    Schema::create('habitaciones', function (Blueprint $table) {
        $table->id();
        $table->foreignId('hospedaje_id')->constrained('hospedajes')->cascadeOnDelete();
        $table->string('numero');
        $table->string('tipo'); // simple, doble, suite, familiar
        $table->decimal('precio', 8, 2);
        $table->unsignedTinyInteger('capacidad');
        $table->string('estado')->default('disponible'); // disponible, ocupada, mantenimiento
        $table->timestamps();
        $table->softDeletes();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habitacions');
    }
};
