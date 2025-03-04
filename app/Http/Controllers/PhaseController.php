<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Phase;

class PhaseController extends Controller
{   public function show(){
    return  view('phases.showphase');
}
    public function index()
    {
        return response()->json(Phase::orderBy('order')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:phases,name',
        ]);

        $lastOrder = Phase::max('order') ?? 0;
        $phase = Phase::create([
            'name' => $request->name,
            'order' => $lastOrder + 1,
        ]);

        return response()->json($phase);
    }

    public function destroy($id)
{
    try {
        $phase = Phase::findOrFail($id);
        $phase->delete();
        return response()->json(['message' => 'Phase deleted successfully']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Cannot delete this phase'], 400);
    }
}


    public function reorder(Request $request)
    {
        foreach ($request->phases as $index => $id) {
            Phase::where('id', $id)->update(['order' => $index + 1]);
        }
        return response()->json(['message' => 'Phases reordered successfully']);
    }
}

