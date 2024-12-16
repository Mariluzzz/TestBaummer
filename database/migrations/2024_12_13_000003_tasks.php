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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->timestamp('deadline')->nullable();
            $table->unsignedBigInteger('collaborator_id');
            $table->enum('priority', ['Baixa', 'Média', 'Alta']);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('executed_at')->nullable();
            $table->foreign('collaborator_id')->references('id')->on('collaborators')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
