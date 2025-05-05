<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::select(['id', 'name', 'slug']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($category) {
                    return '
                        <a href="' . route('categories.show', $category->id) . '" class="btn btn-info btn" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="' . route('categories.edit', $category->id) . '" class="btn btn-warning btn" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-danger delete-btn" data-id="' . $category->id . '" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('backend.categories.index');
    }

    public function create()
    {
        return view('backend.categories.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|unique:categories,slug',
            ], [
                'name.required' => 'The category name is required.',
                'slug.required' => 'The slug is required.',
                'slug.unique' => 'This slug is already in use. Please choose a different one.',
            ]);

            Category::create($request->only(['name', 'slug']));

            return redirect()->route('categories.index')->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating category: ' . $e->getMessage());
        }
    }

    public function show(Category $category)
    {
        return view('backend.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('backend.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|unique:categories,slug,' . $category->id,
            ], [
                'name.required' => 'The category name is required.',
                'slug.required' => 'The slug is required.',
                'slug.unique' => 'This slug is already in use. Please choose a different one.',
            ]);

            $category->update($request->only(['name', 'slug']));

            return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating category: ' . $e->getMessage());
        }
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return response()->json(['success' => true, 'message' => 'Category deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete category.'], 500);
        }
    }
}
