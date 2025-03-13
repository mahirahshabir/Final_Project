<?php

namespace App\Http\Controllers;

use App\Models\CustomField;
use Illuminate\Http\Request;

class CustomFieldController extends Controller
{
        public function index() {
            $customFields = CustomField::all();
            return view('customfield.index', compact('customFields'));
        }

        public function store(Request $request) {
            $request->validate([
                'name' => 'required|string|max:255',
                'field_type' => 'required|string|in:text,number,boolean,date',
            ]);

            CustomField::create($request->all());

            return redirect()->route('custom-fields.index')->with('success', 'Custom field created successfully.');
        }

        public function edit($id) {
            $customField = CustomField::findOrFail($id);
            return view('customfield.edit', compact('customField'));
        }

        public function update(Request $request, $id) {
            $request->validate([
                'name' => 'required|string|max:255',
                'field_type' => 'required|string|in:text,number,boolean,date',
            ]);

            $customField = CustomField::findOrFail($id);
            $customField->update($request->all());

            return redirect()->route('custom-fields.index')->with('success', 'Custom field updated successfully.');
        }

        public function destroy($id) {
            CustomField::findOrFail($id)->delete();
            return redirect()->route('custom-fields.index')->with('success', 'Custom field deleted successfully.');
        }


}
