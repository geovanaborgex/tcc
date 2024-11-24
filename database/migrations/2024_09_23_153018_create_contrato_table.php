<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('contrato', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aluno_id')->constrained('aluno');
            $table->foreignId('profissional_id')->constrained('profissional');
            $table->date('data_inicio');
            $table->date('data_termino');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('contrato');
    }
};
