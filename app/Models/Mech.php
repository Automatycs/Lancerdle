<?php

namespace App\Models;

use App\Enums\MechsPool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mech extends Model
{
    use HasFactory;

	protected $table = 'mechs';

	protected $fillable = [
		'pool',
		'lcp',
		'name',
		'manufacturer',
		'hp',
		'armor',
		'heat_cap',
		'repair_capacity',
		'evasion',
		'e_defense',
		'sensors',
		'tech_attack',
		'save_target',
		'speed',
		'system_points',
		'mounts',
	];

	protected function casts() {
		return [
			'pool' => MechsPool::class,
		];
	}

	public function dailies(): HasMany {
		return $this->hasMany(Daily::class, 'mech_id');
	}
}
