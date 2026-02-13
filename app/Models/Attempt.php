<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attempt extends Model
{
    use HasFactory;

	protected $table = 'attempts';

	protected $fillable = [
		'guess',
		'attempt_number',
		'game_id',
		'response',
	];

	public function game(): BelongsTo {
		return $this->belongsTo(Game::class, 'game_id');
	}
}
