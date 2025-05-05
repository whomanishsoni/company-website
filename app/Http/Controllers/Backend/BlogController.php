<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Blog::with(['categories', 'tags'])->select(['id', 'title', 'slug', 'image', 'is_featured', 'status']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($blog) {
                    return '<input type="checkbox" class="select-checkbox" name="selected_ids[]" value="' . $blog->id . '">';
                })
                ->addColumn('image', function ($blog) {
                    return $blog->image ? Storage::url('blog/' . $blog->image) : asset('images/default-blog-image.jpg');
                })
                ->addColumn('is_featured', function ($blog) {
                    return $blog->is_featured ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-secondary">No</span>';
                })
                ->addColumn('status', function ($blog) {
                    return $blog->status === 'published'
                        ? '<span class="badge badge-success">Published</span>'
                        : '<span class="badge badge-warning">Draft</span>';
                })
                ->addColumn('actions', function ($blog) {
                    return '
                        <a href="' . route('blogs.show', $blog->id) . '" class="btn btn-info" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="' . route('blogs.edit', $blog->id) . '" class="btn btn-warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-danger delete-btn" data-id="' . $blog->id . '" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    ';
                })
                ->rawColumns(['checkbox', 'image', 'is_featured', 'status', 'actions'])
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|in:draft,published',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('blog', $imageName, 'public');
        }

        $blog = Blog::create([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $request->slug,
            'image' => $imageName,
            'is_featured' => $request->is_featured ?? false,
            'status' => $request->status,
        ]);

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

        $imageName = $blog->image;
        if ($request->hasFile('image')) {

            if ($blog->image && Storage::disk('public')->exists('blog/' . $blog->image)) {
                Storage::disk('public')->delete('blog/' . $blog->image);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('blog', $imageName, 'public');
        }

        $blog->update([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $request->slug,
            'image' => $imageName,
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

        try {
            if ($blog->image && Storage::disk('public')->exists('blog/' . $blog->image)) {
                Storage::disk('public')->delete('blog/' . $blog->image);
            }

            $blog->delete();
            return response()->json(['success' => true, 'message' => 'Blog deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete blog.'], 500);
        }
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'selected_ids' => 'required|array',
            'selected_ids.*' => 'exists:blogs,id',
        ]);

        try {
            $selectedCount = count($request->selected_ids);

            if ($selectedCount === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No blogs selected for deletion.'
                ], 400);
            }

            $blogs = Blog::whereIn('id', $request->selected_ids)->get();

            foreach ($blogs as $blog) {
                // Delete associated image if exists
                if ($blog->image && Storage::disk('public')->exists('blog/' . $blog->image)) {
                    Storage::disk('public')->delete('blog/' . $blog->image);
                }

                // Delete the blog post
                $blog->delete();
            }

            $message = $selectedCount > 1 ?
                $selectedCount . ' blogs have been deleted successfully.' :
                '1 blog has been deleted successfully.';

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the selected blogs.'
            ], 500);
        }
    }
}
