<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select(['id', 'name', 'email', 'photo']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('photo', function ($user) {
                    return $user->photo ? asset('storage/users/' . $user->photo) : asset('images/default-user.png');
                })
                ->addColumn('user_info', function ($user) {
                    return $user->name; // This will be used in the render function
                })
                ->addColumn('actions', function ($user) {
                    return '
                        <a href="' . route('users.show', $user->id) . '" class="btn btn-info" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="' . route('users.edit', $user->id) . '" class="btn btn-warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-danger delete-btn" data-id="' . $user->id . '" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    ';
                })
                ->rawColumns(['photo', 'actions'])
                ->make(true);
        }

        return view('backend.users.index');
    }

    public function create()
    {
        return view('backend.users.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ], [
                'name.required' => 'The full name is required.',
                'email.required' => 'The email address is required.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email is already registered.',
                'password.required' => 'The password field is required.',
                'password.min' => 'The password must be at least 8 characters.',
                'password.confirmed' => 'The password confirmation does not match.',
                'photo.image' => 'The uploaded file must be an image.',
                'photo.mimes' => 'Only JPEG, JPG and PNG images are allowed.',
                'photo.max' => 'The image size should not exceed 2MB.',
            ]);

            $photoName = null;
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $photoName = time() . '_' . Str::slug(pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $photo->getClientOriginalExtension();

                try {
                    $photo->storeAs('users', $photoName, 'public');
                } catch (\Exception $e) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Failed to upload photo: ' . $e->getMessage());
                }
            }

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'photo' => $photoName,
            ]);

            return redirect()->route('users.index')
                ->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating user: ' . $e->getMessage());
        }
    }

    public function show(User $user)
    {
        return view('backend.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('backend.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8|confirmed',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'remove_photo' => 'nullable|boolean',
            ], [
                'name.required' => 'The full name is required.',
                'email.required' => 'The email address is required.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email is already registered.',
                'password.min' => 'The password must be at least 8 characters.',
                'password.confirmed' => 'The password confirmation does not match.',
                'photo.image' => 'The uploaded file must be an image.',
                'photo.mimes' => 'Only JPEG, JPG and PNG images are allowed.',
                'photo.max' => 'The image size should not exceed 2MB.',
            ]);

            $photoName = $user->photo;

            // Handle photo removal
            if ($request->has('remove_photo')) {
                try {
                    if ($user->photo && Storage::disk('public')->exists('users/' . $user->photo)) {
                        Storage::disk('public')->delete('users/' . $user->photo);
                    }
                    $photoName = null;
                } catch (\Exception $e) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Failed to remove photo: ' . $e->getMessage());
                }
            }
            // Handle new photo upload
            elseif ($request->hasFile('photo')) {
                try {
                    // Delete old photo if exists
                    if ($user->photo && Storage::disk('public')->exists('users/' . $user->photo)) {
                        Storage::disk('public')->delete('users/' . $user->photo);
                    }

                    $photo = $request->file('photo');
                    $photoName = time() . '_' . Str::slug(pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $photo->getClientOriginalExtension();
                    $photo->storeAs('users', $photoName, 'public');
                } catch (\Exception $e) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Failed to upload photo: ' . $e->getMessage());
                }
            }

            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'photo' => $photoName,
            ];

            // Only update password if provided
            if ($request->password) {
                $updateData['password'] = Hash::make($request->password);
            }

            $user->update($updateData);

            return redirect()->route('users.index')
                ->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating user: ' . $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        try {
            // Delete user photo if exists
            if ($user->photo && Storage::disk('public')->exists('users/' . $user->photo)) {
                Storage::disk('public')->delete('users/' . $user->photo);
            }

            $user->delete();
            return response()->json(['success' => true, 'message' => 'User deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete user.'], 500);
        }
    }
}
