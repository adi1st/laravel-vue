<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Category\CategoryStoreRequest;
use App\Http\Requests\Dashboard\Category\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return Inertia::render('categories/Index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('categories/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            Category::create($data);
            DB::commit();
            return redirect()->route('categories.index')->with('flash', [
                'message' => 'Category created successfully.',
                'variant' => 'default', // atau 'destructive'
                'title'   => 'Success!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('categories.index')->with('flash', [
                'message' => 'Category creation failed: ' . $e->getMessage(),
                'variant' => 'destructive',
                'title'   => 'Failed!',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return Inertia::render('categories/Edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            Category::findOrFail($id)->update($data);
            DB::commit();
            return redirect()->route('categories.index')->with('flash', [
                'message' => 'Category updated successfully.',
                'variant' => 'default', // atau 'destructive'
                'title'   => 'Success!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('categories.index')->with('flash', [
                'message' => 'Category update failed: ' . $e->getMessage(),
                'variant' => 'destructive',
                'title'   => 'Failed!',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            Category::destroy($id);
            DB::commit();
            return redirect()->route('categories.index')->with('flash', [
                'message' => 'Category deleted successfully.',
                'variant' => 'default',
                'title'   => 'Success!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('categories.index')->with('flash', [
                'message' => 'Category deletion failed: ' . $e->getMessage(),
                'variant' => 'destructive',
                'title'   => 'Failed!',
            ]);
        }

    }
}
