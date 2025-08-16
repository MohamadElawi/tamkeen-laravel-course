<?php

namespace App\Http\Controllers\API;

use App\Enums\StatusEnum;
use App\Http\Controllers\API\ApiController;
use App\Http\Requests\UpdateColorsRequest;
use App\Http\Resources\ProductResource;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Policies\ProductPolicy;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductController extends ApiController
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $products = new Product();

        if ($search != null) {
            $products = $products->where('name', 'like', '%' . $search . '%');
        }


        /*
         * $limit = $request->input('limit', 10); //NOTE -  - number of products in a page
         *
         * $page = $request->input('page', 0); //NOTE - number of page
         *
         * $product = Product::all();
         */
        // REVIEW - Clone allow using aggregation fun with cancel

        // all ralation with another models for optimization

        // FIXME -  $count_products = (clone $product)->count();

        // NOTE - after with()fun we need ->get() because is acollection .

        $products = $products->with('categories')->paginate();  /* ->pluck('name', 'id') */

//        $products = $products->categories()->where('name->en','mobile');

        // REVIEW -  $products = $products->filter(fn($product) => $product->price > 1000);

        // REVIEW -   $products = $products->sortBy('name');

        // REVIEW -  $products = $products->map(function ($product) {

        /*
         * $product->price = '$' . number_format($product->price, 2);
         *     return $product;
         * });
         */

        return $this->sendResponce(
            ProductResource::collection($products),
            __('Products_retrieved_successfully'),
            200,
            true
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
    public function store(ProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $category_ids = $request->category_ids;  // REVIEW  - This ids will i hold from request as array .

            $data = $request->validated();
            $data['name']['ar'] = $request->name_ar;
            $data['name']['en'] = $request->name_en;
//
//        $product = Product::create($data);
            $product = $this->productService->create($data);

//         Store the uploaded image to the product instance in the default media collection ('default')
            $product->addMedia($request->file('image'))
                ->toMediaCollection('main-image');


            // Store multiple gallery images to the product instance in the 'gallery' media collection
            foreach ($request->gallery ?? [] as $image) {
                $product->addMedia($image)
                    ->toMediaCollection('gallery');
            }


            $product->categories()->attach($category_ids);  // REVIEW - attach: Adding Records to a Many-to-Many Relationship .

//        $product->categories()->detach($category_ids);


            $product->colors()->sync($request->color_ids);

//        $product->colors()->syncWithoutDetaching($request->color_ids);

            DB::commit();

            // Return JSON response
        return $this->sendResponce(
            new ProductResource($product),
            __('Product_created_successfully'),
            201
        );

        }catch (\Exception $e){
            DB::rollBack();
            $this->sendError('something went wrongs');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $product = $this->productService->getProductById($id, true);
        return $this->sendResponce(
            new ProductResource($product),
            __('Product_retrieved_successfully')
        );

//        $product = Product::with('media')->withTrashed()->find($id);

//        if (!$product) {
//            return $this->sendError(__('This_Product_Not_found'), 404);
//        } else {

//        }
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
    public function update(ProductRequest $request, string $id)
    {
        DB::beginTransaction();
        $product = $this->productService->update($id, $request->validated());

        $this->productService->updateProductCategories($product, $request->category_ids);

        //Store the uploaded image to the product instance in the default media collection ('default')

        if($request->hasFile('image')){
            $product->clearMediaCollection('image');
            $product->addMedia($request->file('image'))
                ->toMediaCollection('main-image');
        }


        if($request->has('gallery')){
            // Store multiple gallery images to the product instance in the 'gallery' media collection
            foreach ($request->gallery ?? [] as $image) {
                $product->clearMediaCollection('gallery');
                $product->addMedia($image)
                    ->toMediaCollection('gallery');
            }
        }


        DB::commit();

        return $this->sendResponce(
            new ProductResource($product),
            __('Product_updated_successfully')
        );


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
//        $product = Product::where('status' ,StatusEnum::ACTIVE)->find($id);
        $product = $this->productService->getProductById($id);
        $product->delete();

        return $this->sendResponce(null, __('The_Product_Is_Deleted_Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function forceDestroy(string $id)
    {
//        $product = Product::withTrashed()->find($id);

        $product = $this->productService->getProductById($id, true);
        $product->forceDelete();

        return $this->sendResponce(null, __('The_Product_Is_Deleted_Successfully'));
    }

    public function clearMedia($id)
    {
//        $product = Product::withTrashed()->find($id);
        $product = $this->productService->getProductById($id);

        if ($product) {
            $product->clearMediaCollection('gallery');
            $product->clearMediaCollection('main-image');

            return $this->sendResponce(null, __('The_Product_Is_Deleted_Successfully'));
        } else {
            return $this->sendError('This Product Not found', 404);
        }
    }

    public function retrieve_active_records()
    {
        $activeProducts = Product::all();  // SECTION -  Retrieves only active products .

        return $this->sendResponce($activeProducts, __('Product_retrieved_successfully'));
    }

    public function soft_deleted_records()
    {
        $allProducts = Product::withTrashed()->get();  // SECTION -  Retrieves all products, including soft-deleted ones .

        return $this->sendResponce(
            ProductResource::collection($allProducts),
            __('Product_retrieved_successfully')
        );
    }

    public function only_soft_deleted_records()
    {
        $deletedProructs = Product::onlyTrashed()->get();  // SECTION - Retrieves only deleted products .
//        $product =$this->productService->getProductById($product_id);

        return $this->sendResponce(
            ProductResource::collection($deletedProructs),
            __('Product_retrieved_successfully')
        );
    }

    public function restore_product($id)  // SECTION - Restore all products with deleted_at flag .
    {
//        $product = Product::withTrashed()->find($id);
        $product = $this->productService->getProductById($id);

        $product->restore();

        return $this->sendResponce(
            new ProductResource($product),
            __('The_Product_restored_Successfully')
        );
    }

    public function updateProductColors($id, UpdateColorsRequest $request)
    {
//        $product = Product::findOrFail($product_id);

        $product = $this->productService->getProductById($id);
        // fetch color ids without duplicating
        $color_ids = array_unique($request->color_ids);


        // Attach colors - adds new relations without affecting existing ones
        // Can create duplicate relations if called multiple times with same IDs
//        $product->colors()->attach($color_ids);

        // Detach colors - removes specified color relations
        // If called with no parameters, removes ALL colors from this product
//        $product->colors()->detach($color_ids);


        // Sync colors - sets the exact list of colors, removing any not in this array
//        $product->colors()->sync($color_ids);


        // Sync color IDs to the product without detaching any existing colors
        // This will only add new colors that aren't already attached
        $product->colors()->syncWithoutDetaching($color_ids);

        return $this->sendResponce(
            new ProductResource($product),
            __('Product colors updated successfully')
        );

    }

}
