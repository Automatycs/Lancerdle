<?php

namespace App\Services;

use App\Models\Mech;

class LancerdleEngine {

	public function compare(Mech $goal, Mech $attempt) {
		$result = [
			'result' => ($goal === $attempt) ? true : false,
			'lcp' => ($goal->lcp === $attempt->lcp) ? true : false,
			'name' => ($goal->name === $attempt->name) ? true : false,
			'manufacturer' => ($goal->manufacturer === $attempt->manufacturer) ? true : false,
			'hp' => $goal->hp - $attempt->hp,
			'armor' => $goal->armor - $attempt->armor,
			'heat_cap' => $goal->heat_cap - $attempt->heat_cap,
			'repair_capacity' => $goal->repair_capacity - $attempt->repair_capacity,
			'evasion' => $goal->evasion - $attempt->evasion,
			'e_defense' => $goal->e_defense - $attempt->e_defense,
			'sensors' => $goal->sensors - $attempt->sensors,
			'tech_attack' => $this->techAttackDiff($goal->tech_attack, $attempt->tech_attack),
			'save_target' => $goal->save_target - $attempt->save_target,
			'speed' => $goal->speed - $attempt->speed,
			'system_points' => $goal->system_points - $attempt->system_points,
			'mounts' => $this->mountDiff($goal->mounts, $attempt->mounts),
		];

		return json_encode($result);
	}

	private function techAttackDiff(int $goal, int $attempt) {
		if ($goal < $attempt) {
			return 1;
		} elseif ($goal > $attempt) {
			return -1;
		}
		return 0;
	}

	private function mountDiff(string $goal, string $attempt) {
		$goal = 0;

		if (substr_count($goal, 'Main') == substr_count($attempt, 'Main')) {
			$goal += 1;
		} else if (substr_count($goal, 'Main') !== 0 && substr_count($attempt, 'Main') !== 0) {
			$goal += 0.5;
		}

		if (substr_count($goal, 'Flex') == substr_count($attempt, 'Flex')) {
			$goal += 1;
		} else if (substr_count($goal, 'Flex') !== 0 && substr_count($attempt, 'Flex') !== 0) {
			$goal += 0.5;
		}

		if (substr_count($goal, 'Heavy') == substr_count($attempt, 'Heavy')) {
			$goal += 1;
		} else if (substr_count($goal, 'Heavy') !== 0 && substr_count($attempt, 'Heavy') !== 0) {
			$goal += 0.5;
		}

		if (substr_count($goal, 'Main/Aux') == substr_count($attempt, 'Main/Aux')) {
			$goal += 1;
		} else if (substr_count($goal, 'Main/Aux') !== 0 && substr_count($attempt, 'Main/Aux') !== 0) {
			$goal += 0.5;
		}

		if (substr_count($goal, 'Aux/Aux') == substr_count($attempt, 'Aux/Aux')) {
			$goal += 1;
		} else if (substr_count($goal, 'Aux/Aux') !== 0 && substr_count($attempt, 'Aux/Aux') !== 0) {
			$goal += 0.5;
		}

		if (substr_count($goal, 'Integrated') == substr_count($attempt, 'Integrated')) {
			$goal += 1;
		} else if (substr_count($goal, 'Integrated') !== 0 && substr_count($attempt, 'Integrated') !== 0) {
			$goal += 0.5;
		}

		if ($goal === 0) {
			return 'none';
		} else if ($goal === 6) {
			return 'ok';
		} else {
			return 'partial';
		}
	}
}
