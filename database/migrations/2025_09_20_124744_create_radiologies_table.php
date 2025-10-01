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
        Schema::create('radiologies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('radiology_file');
            $table->string('cost');
            $table->string('note');
            $table->foreignId('examination_id')->constrained('examinations')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('radiologies');
    }
};
