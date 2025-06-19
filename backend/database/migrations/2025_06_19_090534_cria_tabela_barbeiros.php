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
        Schema::create("barbeiros", function (Blueprint $table) {
            $table->increments("barbeiro_id");
            $table->string("nome", 255);
            $table->date("data_nascimento");
            $table->date("data_contratacao");
            $table->boolean("ativo");
            $table->timestamp("data_criacao")->useCurrent();
            $table->timestamp("data_atualizacao")->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("barbeiros");
    }
};
