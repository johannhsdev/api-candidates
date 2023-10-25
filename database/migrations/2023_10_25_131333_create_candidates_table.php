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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('source');
            $table->unsignedBigInteger('owner'); // Id del usuario responsable
            $table->unsignedBigInteger('created_by'); // Id del usuario que ha creado el candidato
            $table->timestamps();

            // Asegúrate de agregar las restricciones de clave externa según sea necesario
            $table->foreign('owner')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
