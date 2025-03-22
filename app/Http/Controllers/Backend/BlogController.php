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
            $data = Blog::with(['categories', 'tags'])->select(['id', 'title', 'slug', 'image', 'is_featured', 'status']);
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
                ->rawColumns(['actions', 'image', 'is_featured', 'status'])
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image validation
            'is_featured' => 'nullable|boolean', // Featured validation
            'status' => 'required|in:draft,published', // Status validation
            'categories' => 'nullable|array',
            'tags' => 'nullable|array',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = 'images/blog/' . $imageName;
            $image->move(public_path('images/blog'), $imageName);
        }

        $blog = Blog::create([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $request->slug,
            'image' => $imagePath,
            'is_featured' => $request->is_featured ?? false,
            'status' => $request->status,
        ]);

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|in:draft,published',
            'categories' => 'nullable|array',
            'tags' => 'nullable|array',
        ]);

        // Handle image upload
        $imagePath = $blog->image;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($blog->image && file_exists(public_path($blog->image))) {
                unlink(public_path($blog->image));
            }
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = 'images/blog/' . $imageName;
            $image->move(public_path('images/blog'), $imageName);
        }

        $blog->update([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $request->slug,
            'image' => $imagePath,
            'is_featured' => $request->is_featured ?? false,
            'status' => $request->status,
        ]);

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
        if ($blog->image && file_exists(public_path($blog->image))) {
            unlink(public_path($blog->image));
        }
    
        $blog->delete();
    
        return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully.');
    }
    
}
