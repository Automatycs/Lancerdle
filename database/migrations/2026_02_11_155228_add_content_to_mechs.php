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
			$table->string('manufacturer')->after('name');
			$table->integer('repair_capacity')->after('heat_cap');
			$table->integer('evasion')->after('repair_capacity');
			$table->integer('e_defense')->after('evasion');
			$table->integer(column: 'sensors')->after('e_defense');
			$table->integer('tech_attack')->after('sensors');
			$table->integer('save_target')->after('tech_attack');
			$table->integer('speed')->after('save_target');
			$table->integer('system_points')->after('speed');
			$table->integer('mounts')->after('system_points');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mechs', function (Blueprint $table) {
            $table->dropColumn([
				'manufacturer',
				'evasion',
				'e_defense',
				'sensors',
				'tech_attack',
				'repair_capacity',
				'save_target',
				'speed',
				'system_points',
				'mounts',
			]);
        });
    }
};
