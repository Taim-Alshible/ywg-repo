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
        Schema::table('radiologies', function (Blueprint $table) {
            $table->renameColumn('name', 'radiology_name');
            $table->renameColumn('cost', 'radiology_cost');
            $table->renameColumn('note', 'radiology_note');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('radiologies', function (Blueprint $table) {
            $table->renameColumn('radiology_name', 'name');
            $table->renameColumn('radiology_cost', 'cost');
            $table->renameColumn('radiology_note', 'note');
        });
    }
};
