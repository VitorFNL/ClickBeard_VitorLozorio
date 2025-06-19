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
        Schema::create("usuarios", function (Blueprint $table) {
            $table->increments("usuario_id");
            $table->string("nome");
            $table->string("email")->unique();
            $table->string("senha");
            $table->boolean("admin")->default(false);
            $table->timestamp("data_criacao")->useCurrent();
            $table->timestamp("data_atualizacao")->nullable()->useCurrent();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
