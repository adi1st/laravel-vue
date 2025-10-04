<?php
namespace App\Http\Controllers\Dashboard;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Category\CategoryStoreRequest;
use App\Http\Requests\Dashboard\Category\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CategoryController extends Controller
{
    protected $category_repo;
    public function __construct(CategoryRepository $category_repo)
    {
        $this->category_repo = $category_repo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters    = $request->all();
        $categories = $this->category_repo->getAll($filters);
        return Inertia::render('categories/Index', [
            'categories' => CategoryResource::collection($categories),
            'filters'    => $filters,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                $data['image'] = Helper::upload_file(
                    $request->file('image'),
                    $this->category_repo->upload_directory
                );
            }
            $this->category_repo->store($data);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                $category = $this->category_repo->getById($id);
                Helper::delete_file($category->image);
                $data['image'] = Helper::upload_file(
                    $request->file('image'),
                    $this->category_repo->upload_directory
                );
            }
            $this->category_repo->update($id, $data);
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
