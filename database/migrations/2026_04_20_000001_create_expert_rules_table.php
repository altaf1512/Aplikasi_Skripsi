<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expert_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->enum('hypothesis', ['Beli', 'Tahan', 'Jual']);
            $table->float('cf_pakar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expert_rules');
    }
};
