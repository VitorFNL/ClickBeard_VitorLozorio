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
        Schema::create("barbeiros_especialidades", function (Blueprint $table) {
            $table->unsignedInteger('barbeiro_id');
            $table->unsignedInteger('especialidade_id');
            $table->timestamp("data_criacao")->useCurrent();


            $table->primary(["barbeiro_id","especialidade_id"]);


            $table->foreign("barbeiro_id")
                  ->references("barbeiro_id")
                  ->on("barbeiros")
                  ->onDelete('cascade');

            $table->foreign("especialidade_id")
                  ->references("especialidade_id")
                  ->on("especialidades")
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("barbeiros_especialidades");
    }
};
