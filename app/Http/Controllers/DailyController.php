<?php

namespace App\Http\Controllers;

use App\Http\Requests\DailyRequest;
use App\Models\Daily;
use Auth;
use Illuminate\Http\Request;

class DailyController extends Controller
{

    public function index() {
		$dailies = Daily::get();

		return response()->json($dailies);
	}

	public function store(DailyRequest $request) {
		$daily = new Daily($request->validated());
		$daily->save();

		return response()->json($daily);
	}

	public function show(string $id) {
		$daily = Daily::where('id', $id)->with('mech')->get();

		return response()->json($daily);
	}

	public function update(DailyRequest $request, string $id) {
		$daily = Daily::find($id);
		$daily->update($request->validated());

		return response()->json($daily);
	}

	public function delete(string $id) {
		Daily::destroy($id);

		return response()->json([
			'message' => 'Element deleted',
		]);
	}
}
