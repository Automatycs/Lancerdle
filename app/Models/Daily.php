<?php

namespace App\Models;

use App\Enums\MechsPool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Daily extends Model
{
    use HasFactory;

	protected $table = 'dailies';

	protected $fillable = [
		'date',
		'pool',
		'mech_id',
	];

	protected function casts() {
		return [
			'pool' => MechsPool::class,
		];
	}

	public function mech(): BelongsTo {
		return $this->belongsTo(Mech::class, 'mech_id');
	}

	public function games(): HasMany {
		return $this->hasMany(Game::class, 'daily_id');
	}
}
