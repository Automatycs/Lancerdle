<?php

use App\Models\Daily;
use App\Models\User;
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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
			$table->foreignIdFor(Daily::class, 'daily_id');
			$table->enum('state', ['ongoing', 'won', 'lost'])->default('ongoing');
			$table->foreignIdFor(User::class, 'user_id')->nullable();
			$table->string('guest_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
