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
    Schema::create('hospedaje_user', function (Blueprint $table) {
        $table->id();
        $table->foreignId('hospedaje_id')->constrained('hospedajes')->cascadeOnDelete();
        $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
        $table->string('rol_hospedaje'); // propietario, recepcionista
        $table->timestamps();

        $table->unique(['hospedaje_id', 'user_id']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospedaje_user');
    }
};
