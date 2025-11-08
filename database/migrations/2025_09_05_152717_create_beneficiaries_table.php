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
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->string('fName');
            $table->string('father_name');
            $table->string('lName');
            $table->string('phone');
            $table->integer('nationalNum')->nullable();
            $table->integer('age');
            $table->text('location');
            $table->integer('numOfPeople');
            $table->string('size')->nullable();
            $table->boolean('delivered')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};
