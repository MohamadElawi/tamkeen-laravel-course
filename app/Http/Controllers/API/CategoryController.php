<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\ApiController;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\CategoryRequest;

use App\Models\Category;
use Illuminate\Http\Request;

use App;

class CategoryController extends ApiController
{
    use App\Traits\SluggableTrait;

    protected $categoryService;

    public function __construct(App\Services\CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    protected $locale;

    /* public function __construct(Request $request)
    {
        $this->locale = $request->header('locale') ?? 'en';

        App::setLocale($this->locale);
    } */
    public function index(Request $request)
    {
        $categories = $this->categoryService->getAll();
        return $this->sendResponce(
            CategoryResource::collection($categories),
            __('Categories_retrieved_successfully')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $category = $this->categoryService->create($request->validated());
        return $this->sendResponce(
            new CategoryResource($category),
            __('Category_stored_successfully'),
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = $this->categoryService->getCategoryById($id);

        return $this->sendResponce(
            new CategoryResource($category),
            __('Category_retrieved_successfully')
        );
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $category = $this->categoryService->update($id, $request->validated());
        return $this->sendResponce(
            new CategoryResource($category),
            __('Category_updated_successfully')
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        $this->categoryService->delete($id);
        return $this->sendResponce(null, __('Category_deleted_successfully'));
    }


    public function getProductsByCategory($id)
    {
        $category = $this->categoryService->getCategoryById($id);

        return $category->products()->where('price', 1000.00)->get();
    }
}
