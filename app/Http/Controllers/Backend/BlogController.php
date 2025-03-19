<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Blog::with(['categories', 'tags'])->select(['id', 'title', 'slug']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($blog) {
                    return '
                        <a href="' . route('blogs.show', $blog->id) . '" class="btn btn-info btn" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="' . route('blogs.edit', $blog->id) . '" class="btn btn-warning btn" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="' . route('blogs.destroy', $blog->id) . '" method="POST" style="display:inline;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn" title="Delete" onclick="return confirm(\'Are you sure you want to delete this blog?\')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('backend.blogs.index');
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('backend.blogs.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => 'required|string|unique:blogs,slug',
            'categories' => 'nullable|array',
            'tags' => 'nullable|array',
        ]);

        $blog = Blog::create($request->only(['title', 'content', 'slug']));

        // Attach categories and tags
        if ($request->has('categories')) {
            $blog->categories()->attach($request->categories);
        }

        if ($request->has('tags')) {
            $blog->tags()->attach($request->tags);
        }

        return redirect()->route('blogs.index')->with('success', 'Blog created successfully.');
    }

    public function show(Blog $blog)
    {
        return view('backend.blogs.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('backend.blogs.edit', compact('blog', 'categories', 'tags'));
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => 'required|string|unique:blogs,slug,' . $blog->id,
            'categories' => 'nullable|array',
            'tags' => 'nullable|array',
        ]);

        $blog->update($request->only(['title', 'content', 'slug']));

        // Sync categories and tags
        if ($request->has('categories')) {
            $blog->categories()->sync($request->categories);
        }

        if ($request->has('tags')) {
            $blog->tags()->sync($request->tags);
        }

        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully.');
    }
}