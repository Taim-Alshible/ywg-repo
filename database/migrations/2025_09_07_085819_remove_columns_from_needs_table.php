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
        Schema::table('needs', function (Blueprint $table) {
            $table->dropForeign(['beneficiary_id']);
            $table->dropColumn(['priority', 'delivered', 'beneficiary_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('needs', function (Blueprint $table) {
            $table->enum('priority', ['high', 'medium', 'low'])->nullable();
            $table->boolean('delivered')->nullable();
             $table->unsignedBigInteger('beneficiary_id');
            $table->foreign('beneficiary_id')->constrained('beneficiaries')->cascadeOnDelete();
        });
    }
};
