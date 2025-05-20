<?php

namespace App\Http\Controllers\Api;

use App\Enums\Enums\Media\ColorMediaEnum;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\ColorRequest;
use App\Http\Resources\ColorResource;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $colors = Color::paginate($request->count);
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

        $color = Color::create($request->validated());

        if($request->filled('image')){
            $color->addMedia($request->file('image'))
                ->toMediaCollection(ColorMediaEnum::MAIN_IMAGE->value);
        }


        return $this->sendResponce($color ,'Color Created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $color = Color::findOrFail($id);

//        if($color){
            return $this->sendResponce(ColorResource::make($color) ,'Color retrived successfully');
//        }

//        else{
//            abort(404);
//        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ColorRequest $request, string $id)
    {
        $color = Color::findOrFail($id);

        $color->update($request->validated());

        if($request->filled('image')){
            $color->clearMediaCollection(ColorMediaEnum::MAIN_IMAGE->value);
            $color->addMedia($request->file('image'))->toMediaCollection(ColorMediaEnum::MAIN_IMAGE->value);
        }

        return $this->sendResponce($color ,'Color Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $color = Color::findOrFail($id);
        $color->delete();
        return $this->sendResponce(null ,  'Color Deleted successfully');
    }
}
