<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('treino', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->constrained('contrato');
            $table->string('categoria', 100);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('treino');
    }
};
