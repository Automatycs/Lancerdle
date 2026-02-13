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
        Schema::table('mechs', function (Blueprint $table) {
            $table->enum('pool', ['base', 'official', 'extended'])->default('base')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mechs', function (Blueprint $table) {
            $table->dropColumn('pool');
        });
    }
};
