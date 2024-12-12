<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('aluno', function (Blueprint $table) {
            $table->id();
            $table->string('telefone', 45)->nullable();
            $table->float('peso')->nullable();
            $table->float('altura')->nullable();
            $table->text('biografia')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aluno');
    }
};
