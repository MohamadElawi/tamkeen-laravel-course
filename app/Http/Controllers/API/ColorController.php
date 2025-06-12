<?php

namespace App\Http\Controllers\API;

use App\Enums\Media\ColorMediaEnum;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\ColorRequest;
use App\Http\Resources\ColorResource;
use App\Models\Color;
use App\Services\ColorService;
use Illuminate\Http\Request;

class ColorController extends ApiController
{
    protected $colorService ;

    public function __construct(ColorService $colorService)
    {
        $this->colorService = $colorService ;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $colors = $this->colorService->getAll($request->count);
        return $this->sendResponce(
            ColorResource::collection($colors) ,
            'Retrived colors successfully',
            200 ,
            true
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ColorRequest $request)
    {
        $data = $request->validated();
        $data['status'] = StatusEnum::INACTIVE ;

        $color = $this->colorService->create($data);

        return $this->sendResponce($color ,'Color Created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $color = $this->colorService->getColorById($id);
        return $this->sendResponce(ColorResource::make($color) ,'Color retrived successfully');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ColorRequest $request, string $id)
    {
        $color = $this->colorService->update($id , $request->validated());

        return $this->sendResponce($color ,'Color Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->colorService->delete($id);
        return $this->sendResponce(null ,  'Color Deleted successfully');
    }
}
