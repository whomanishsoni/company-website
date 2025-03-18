<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\State;

class JoinController extends Controller
{
    public function index()
    {
        $states = \App\Models\State::orderBy('name', 'asc')->get();
        return view('frontend.join', compact('states'));
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

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Thank you for joining us! We will contact you soon.');
    }
}
