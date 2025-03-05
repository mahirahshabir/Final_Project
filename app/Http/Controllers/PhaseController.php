<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Phase;

class PhaseController extends Controller
{   public function create()
    {
        return view('phases.showphase');
    }

    public function index()
    {
        return response()->json(Phase::all());
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $phase = Phase::create(['name' => $request->name]);

    if ($phase) {
        return response()->json(['success' => true, 'phase' => $phase], 200);
    } else {
        return response()->json(['success' => false, 'message' => 'Failed to add phase'], 500);
    }
}


public function destroy($id)
{
    $phase = Phase::find($id);

    if (!$phase) {
        return response()->json(['success' => false, 'message' => 'Phase not found'], 404);
    }

    $phase->delete();

    return response()->json(['success' => true, 'message' => 'Phase deleted successfully']);
}






    public function reorder(Request $request)
    {
        foreach ($request->phases as $index => $id) {
            Phase::where('id', $id)->update(['order' => $index + 1]);
        }
        return response()->json(['message' => 'Phases reordered successfully']);
    }
}

