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
        // Get categories by name
//        $query = Category::orderBy('id', 'Asc');
//
//        if ($request->name_en) {
//            $query->where('name->en', $request->id);
//        }
//
//        $categories = $query
//            ->when($request->name_en, fn($q) => $q->where('name->en', $request->name_en))
//            ->with('products')->get();


         // Get all categories with their related products
//        $categories = Category::with('products')->get();


         // Get categories that have products with price equal to "1,000.00"
        $categories = Category::whereHas('products', function ($q) {
            $q->where('price', '1,000.00');
        })->get();

        // Get categories that have products with their related products
//        $categories = Category::withWhereHas('products')->get();


        // Get categories where has products with price equal to 1000.00
        $categories = Category::whereRelation('products', 'price', 1000.00)
            ->get();

        return $this->sendResponce(
            CategoryResource::collection($categories),
            __('Categories_retrieved_successfully')
        );
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
    public function store(CategoryRequest $request)
    {
        //        $category = Category::create($request->validated());
        $category = new Category();

        $category->setTranslations('name', [
            'en' => $request->name_en,
            'ar' => $request->name_ar
        ]);

        $category->slug = $this->generateSlug($request->name_en);
        $category->save();

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
        $category = Category::find($id);

        if (!$category) {
            return $this->sendError(__('This_categories_Not_found'));
        } else {
            return $this->sendResponce(
                new CategoryResource($category),
                __('Category_retrieved_successfully')
            );
        }
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
    public function update(CategoryRequest $request, string $id)
    {
        $category = Category::find($id);
        if ($category) {
            if ($request->has('name_ar')) {
                $category->setTranslation('name', 'ar', $request->name_ar);
            }
            if ($request->has('name_en')) {
                $category->setTranslation('name', 'en', $request->name_en);
            }
            $category->save();

            return $this->sendResponce(
                new CategoryResource($category),
                __('Category_updated_successfully')
            );
        } else {
            return $this->sendError(__('This_category_Not_found'), 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return $this->sendResponce(null, __('Category_deleted_successfully'));
        } else {
            return $this->sendError(__('This_category_Not_found'), 404);
        }
    }


    public function getProductsByCategory($categoryId){
        $category = Category::find($categoryId);

        if(!$category)
            abort(404);

        return $category->products()->where('price',1000.00)->get();
    }

    public function setName()
    {
        // TODO: Implement setName() method.
    }
}
