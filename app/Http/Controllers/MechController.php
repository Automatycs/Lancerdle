<?php

namespace App\Http\Controllers;

use App\Http\Requests\MechRequest;
use App\Models\Mech;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MechController extends Controller
{
    
	public function index() {
		$mechs = Mech::get();

		return response()->json($mechs);
	}

	/*
	A faire quand j'aurais des views
	public function create() {

	}
	*/

	public function store(MechRequest $request) {
		$mech = new Mech($request->validated());
		$mech->save();

		return response()->json($mech);
	}

	public function show(string $id) {
		$mech = Mech::where('id', $id)->with('dailies')->get();

		return response()->json($mech);
	}

	public function update(MechRequest $request, string $id) {
		$mech = Mech::find($id);
		$mech->update($request->validated());

		return response()->json($mech);
	}

	public function destroy(string $id) {
		Mech::destroy($id);

		return response()->json(['message' => 'deleted']);
	}
}
