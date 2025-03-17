<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\State;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Fetch members with state data
            $data = Member::with('state')->select(['id', 'name', 'email', 'city', 'state_id', 'created_at']);
    
            return DataTables::of($data)
                ->addIndexColumn() // Add an index column for row numbering
                ->addColumn('state', function ($member) {
                    return $member->state->name; // Access the state name and return it
                })
                ->addColumn('actions', function ($member) {
                    return '
                        <a href="' . route('members.show', $member->id) . '" class="btn btn-info" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="' . route('members.edit', $member->id) . '" class="btn btn-warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="' . route('members.destroy', $member->id) . '" method="POST" style="display:inline;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger" title="Delete" onclick="return confirm(\'Are you sure you want to delete this member?\')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    ';
                })
                ->rawColumns(['actions']) // Ensure actions are rendered as HTML
                ->make(true); // Return the data in DataTables JSON format
        }
    
        return view('backend.members.index');
    }
    

    public function create()
    {
        $states = State::orderBy('name', 'asc')->get();
        return view('backend.members.create', compact('states'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'whatsapp' => 'required|string|max:10',
            'alt_no' => 'nullable|string|max:10',
            'email' => 'required|email|max:255|unique:members,email',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state_id' => 'required|exists:states,id',
            'pincode' => 'required|string|max:6',
            'business' => 'nullable|string|max:255',
            'blood_group' => 'nullable|string',
            'inspirer' => 'nullable|string|max:255',
            'cooperation_field' => 'nullable|string|max:255',
        ]);

        Member::create([
            'name' => $request->name,
            'father_name' => $request->father_name,
            'dob' => $request->dob,
            'whatsapp' => $request->whatsapp,
            'alt_no' => $request->alt_no,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
            'state_id' => $request->state_id,
            'pincode' => $request->pincode,
            'business' => $request->business,
            'blood_group' => $request->blood_group,
            'inspirer' => $request->inspirer,
            'cooperation_field' => $request->cooperation_field,
        ]);

        return redirect()->route('members.index')->with('success', 'Member created successfully.');
    }

    public function show(Member $member)
    {
        return view('backend.members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        $states = State::orderBy('name', 'asc')->get();
        return view('backend.members.edit', compact('member', 'states'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'whatsapp' => 'required|string|max:10',
            'alt_no' => 'nullable|string|max:10',
            'email' => 'required|email|max:255|unique:members,email,' . $member->id,
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state_id' => 'required|exists:states,id',
            'pincode' => 'required|string|max:6',
            'business' => 'nullable|string|max:255',
            'blood_group' => 'nullable|string',
            'inspirer' => 'nullable|string|max:255',
            'cooperation_field' => 'nullable|string|max:255',
        ]);

        $member->update([
            'name' => $request->name,
            'father_name' => $request->father_name,
            'dob' => $request->dob,
            'whatsapp' => $request->whatsapp,
            'alt_no' => $request->alt_no,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
            'state_id' => $request->state_id,
            'pincode' => $request->pincode,
            'business' => $request->business,
            'blood_group' => $request->blood_group,
            'inspirer' => $request->inspirer,
            'cooperation_field' => $request->cooperation_field,
        ]);

        return redirect()->route('members.index')->with('success', 'Member updated successfully.');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Member deleted successfully.');
    }
}