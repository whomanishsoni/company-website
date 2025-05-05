<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TagController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Tag::select(['id', 'name', 'slug']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($tag) {
                    return '
                        <a href="' . route('tags.show', $tag->id) . '" class="btn btn-info btn" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="' . route('tags.edit', $tag->id) . '" class="btn btn-warning btn" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-danger delete-btn" data-id="' . $tag->id . '" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('backend.tags.index');
    }

    public function create()
    {
        return view('backend.tags.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|unique:tags,slug|regex:/^[a-z0-9-]+$/',
            ], [
                'name.required' => 'The tag name is required.',
                'slug.required' => 'The slug is required.',
                'slug.unique' => 'This slug is already in use. Please choose a different one.',
                'slug.regex' => 'Slug can only contain lowercase letters, numbers, and hyphens.',
            ]);

            Tag::create($request->only(['name', 'slug']));

            return redirect()->route('tags.index')
                ->with('success', 'Tag created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating tag: ' . $e->getMessage());
        }
    }

    public function show(Tag $tag)
    {
        return view('backend.tags.show', compact('tag'));
    }

    public function edit(Tag $tag)
    {
        return view('backend.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|unique:tags,slug,' . $tag->id . '|regex:/^[a-z0-9-]+$/',
            ], [
                'name.required' => 'The tag name is required.',
                'slug.required' => 'The slug is required.',
                'slug.unique' => 'This slug is already in use. Please choose a different one.',
                'slug.regex' => 'Slug can only contain lowercase letters, numbers, and hyphens.',
            ]);

            $tag->update($request->only(['name', 'slug']));

            return redirect()->route('tags.index')
                ->with('success', 'Tag updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating tag: ' . $e->getMessage());
        }
    }

    public function destroy(Tag $tag)
    {
        try {
            $tag->delete();
            return response()->json(['success' => true, 'message' => 'Tag deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete tag.'], 500);
        }
    }
}
