<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('exercicio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('treino_id')->constrained('treino');
            $table->string('nome', 45);
            $table->string('observacao', 100)->nullable();
            $table->integer('carga')->nullable();
            $table->integer('series');
            $table->integer('repeticoes');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('exercicio');
    }
};
