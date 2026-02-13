<?php

namespace App\Http\Controllers;

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
			return response()->json([
				'message' => 'error'
			]);
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

			if (Game::where('guest_id', $guest_id)->where('daily_id', $target->id->first)) {
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
		$game->load('tries');

		return response()->json($game);
	}

	public function guess(Request $request) {
		$request->validate([
			'game_id' => 'required|exists:games,id',
			'guess' => 'required|string|exists:mechs,name',
		]);

		$game = Game::firstOrFail($request->game_id);
		if ($game->state !== 'ongoing') {
			return response()->json($game);
		}
		$goal = $game->daily()->mech()->get();
		$attempt = Mech::firstOrFail()->where('name', $request->guess);

		$result = LancerdleEngine::compare()
		
	}
}
