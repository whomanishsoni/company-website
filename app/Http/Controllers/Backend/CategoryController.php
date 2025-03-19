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
                        <form action="' . route('categories.destroy', $category->id) . '" method="POST" style="display:inline;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn" title="Delete" onclick="return confirm(\'Are you sure you want to delete this category?\')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
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
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug',
        ]);

        Category::create($request->only(['name', 'slug']));

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
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
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug,' . $category->id,
        ]);

        $category->update($request->only(['name', 'slug']));

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}