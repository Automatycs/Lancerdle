<?php

namespace App\Models;

use App\Enums\GameStates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasFactory;

	protected $table = 'games';

	protected $fillable = [
		'daily_id',
		'state',
		'user_id',
		'guest_id',
	];

	protected function casts() {
		return [
			'state' => GameStates::class,
		];
	}

	public function daily(): BelongsTo {
		return $this->belongsTo(Daily::class, 'daily_id');
	}

	public function user(): BelongsTo {
		return $this->belongsTo(User::class, 'user_id');
	}

	public function attempts(): HasMany {
		return $this->hasMany(Attempt::class, 'game_id');
	}
}
