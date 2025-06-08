<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Position;
use Illuminate\Validation\Rule;


class PositionController extends Controller
{
   public function store(Request $request)
{
    $request->validate([
        'position_name' => 'required|unique:positions,position_name',
        'reports_to' => [
            'nullable', 'string',
            function ($attribute, $value, $fail) {
                $normalized = $value === '' ? null : $value;

                if ($normalized !== null && !Position::where('position_name', $normalized)->exists()) {
                    $fail("The selected '$attribute' position does not exist.");
                }

                if ($normalized === null && Position::whereNull('reports_to')->exists()) {
                    $fail('Only one position is allowed without a "reports_to" (top-level position).');
                }
            }
        ],
    ]);

    $position = Position::create([
        'position_name' => $request->position_name,
        'reports_to' => $request->reports_to ?: null
    ]);

    return response()->json($position, 201);
}


    public function index(Request $request)
    {
        $query = Position::query();

        if ($request->has('search')) {
            $query->where('position_name', 'like', '%' . $request->search . '%');
        }

        $positions = $query->orderBy('position_name')->get();

        return response()->json($positions);
    }

    public function show($id)
    {
        $position = Position::findOrFail($id);
        return response()->json($position);
    }

public function update(Request $request, $id)
{
    $position = Position::findOrFail($id);

    // Normalize reports_to to real null before validation
    $reportsToInput = $request->input('reports_to');
    $normalized = ($reportsToInput === '' || $reportsToInput === 'None') ? null : $reportsToInput;

    // Merge it into the request
    $request->merge(['reports_to' => $normalized]);

    $request->validate([
        'position_name' => ['required', Rule::unique('positions')->ignore($id)],
        'reports_to' => [
            'nullable',
            'string',
            function ($attribute, $value, $fail) use ($id) {
                if (is_null($value)) {
                    // Block if another top-level already exists
                    $alreadyTopLevel = Position::whereNull('reports_to')->where('id', '!=', $id)->exists();
                    if ($alreadyTopLevel) {
                        $fail('Only one position can be top-level (no "reports_to").');
                    }
                } else {
                    // Ensure the position name exists
                    $exists = Position::where('position_name', $value)->exists();
                    if (!$exists) {
                        $fail("The selected 'reports_to' position does not exist.");
                    }
                }
            }
        ]
    ]);

    $position->update([
        'position_name' => $request->input('position_name'),
        'reports_to' => $normalized,
    ]);

    return response()->json($position);
}


    public function destroy($id)
    {
        $position = Position::findOrFail($id);
        $position->delete();

        return response()->json(['message' => 'Position deleted']);
    }
}

