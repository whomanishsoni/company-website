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
                        <form action="' . route('tags.destroy', $tag->id) . '" method="POST" style="display:inline;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn" title="Delete" onclick="return confirm(\'Are you sure you want to delete this tag?\')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
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
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:tags,slug',
        ]);

        Tag::create($request->only(['name', 'slug']));

        return redirect()->route('tags.index')->with('success', 'Tag created successfully.');
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
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:tags,slug,' . $tag->id,
        ]);

        $tag->update($request->only(['name', 'slug']));

        return redirect()->route('tags.index')->with('success', 'Tag updated successfully.');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('tags.index')->with('success', 'Tag deleted successfully.');
    }
}