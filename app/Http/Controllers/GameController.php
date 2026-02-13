<?php

namespace App\Http\Controllers;

use App\Models\Attempt;
use App\Models\Daily;
use App\Models\Game;
use App\Models\Mech;
use App\Services\LancerdleEngine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Str;

class GameController extends Controller
{
    public function get_game(Request $request) {
		$target = Daily::where('date', $request->date)->where('pool', $request->pool)->first();

		if (!$target) {
			return response()->json($request);
		}

		if (Auth::user()) {
			if (Game::where('user_id', Auth::id())->where('daily_id', $target->id)->first()) {
				$game = Game::where('user_id', Auth::id())->where('daily_id', $target->id)->first();
			} else {
				$game = Game::create([
					'daily_id' => $target->id,
					'state' => 'ongoing',
					'user_id' => Auth::id(),
					'guest_id' => null
				]);
			}
		} else {
			if (!request()->cookie('guest_id')) {
				$guest_id = Str::uuid();
				cookie()->queue(cookie('guest_id', $guest_id, 60*24*365*5));
			} else {
				$guest_id = request()->cookie('guest_id');
			}

			if (Game::where('guest_id', $guest_id)->where('daily_id', $target->id)->first()) {
				$game = Game::where('guest_id', $guest_id)->where('daily_id', $target->id)->first();	
			} else {
				$game = Game::create([
					'daily_id' => $target->id,
					'state' => 'ongoing',
					'user_id' => null,
					'guest_id' => $guest_id
				]);
			}
		}
		$game->load('attempts');

		return response()->json([
			'game' => $game,
			'state' => $game->state,
			'attempts' => $game->attempts()->orderBy('attempt_number')->get(),
		]);
	}

	public function guess(Request $request) {
		$request->validate([
			'game_id' => 'required|exists:games,id',
			'guess' => 'required|string|exists:mechs,name',
		]);

		$game = Game::where('id', $request->game_id)->firstOrFail();
		if ($game->state !== 'ongoing') {
			return response()->json([
				'state' => $game->state,
				'attempts' => $game->attempts()->orderBy('attempt_number')->get(),
			]);
		}
		$goal = $game->daily()->mech()->get();
		$guess = Mech::where('name', $request->guess)->firstOrFail();

		$result = LancerdleEngine::compare($goal, $guess);
		
		$attempt = Attempt::create([
			'guess' => $request->$guess,
			'attempt_number' => $game->attempts()->count() + 1,
			'game_id' => $game->id,
			'response' => json_encode($result),
		]);

		if ($result['result'] === true) {
			$game->update(['state' => 'won']);
		} elseif ($attempt->attempt_number >= 6) {
			$game->update(['state' => 'lost']);
		}
		$game->load('attempts')->orderBy('attempt_number');

		return response()->json([
			'state' => $game->state,
			'attempts' => $game->attempts()->orderBy('attempt_number')->get(),
		]);
	}
}
