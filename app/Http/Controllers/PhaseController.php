<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Phase;
use App\Models\Task;

class PhaseController extends Controller
{

public function show()
{   $phases= Phase::all();
    return view('phases.showphase',compact('phases'));
}

public function index()
{
 $phases = Phase::with('tasks')->get(); // Load tasks inside each phase
 return view('tasks.index', compact('phases'));
 }

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);
    $maxOrder = Phase::max('order');

    $phase = Phase::create([
        'name' => $request->name,
        'order' => $maxOrder + 1,

    ]);

    if ($phase) {
        return redirect()->back()->with('success', 'Phase added successfully!');
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

    // return response()->json(['success' => true, 'message' => 'Phase deleted successfully']);
}
public function edit($id)
{
    $phase = Phase::findOrFail($id); // Fetch the phase by ID
    return view('phases.edit', compact('phase')); // Pass data to the edit view
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $phase = Phase::findOrFail($id);
    $phase->update(['name' => $request->name]);

    return redirect()->route('phases.show')->with('success', 'Phase updated successfully!');
}

public function reorder(Request $request)
{
        foreach ($request->phases as $index => $id) {
            Phase::where('id', $id)->update(['order' => $index + 1]);
        }
        return response()->json(['message' => 'Phases reordered successfully']);
}


}

