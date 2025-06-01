<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admin\AdminRequest;
use App\Http\Resources\Admin\Admin\AdminResource;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AdminController extends ApiController implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:create admins',only: ['store'])
        ];
    }


    public function index(Request $request){
        $currentAdminId = auth('admin')->id();
        $admins = Admin::where('id','!=',$currentAdminId)->paginate($request->count); // by default 15;

        return $this->sendResponce(AdminResource::collection($admins),
                'Admins retrieved successfully',
                '200',
            true);
    }


    public function store(AdminRequest $request){
        $data = $request->validated();

        $admin = Admin::create($data);

        return $this->sendResponce(AdminResource::make($admin) ,'Admin created successfully');
    }

    public function show($id){
        return $admin = Admin::with(['roles','permissions'])->findOrFail($id);

        return $this->sendResponce(AdminResource::make($admin),
            'Admin retrieved successfully');
    }

    public function toggleStatus($id){
        $currentAdminId = auth('admin')->id();

        if($id == $currentAdminId){
            return $this->sendError("You can't change password");
        }

        $admin = Admin::findOrFail($id);

        if($admin->status == StatusEnum::ACTIVE)
            $admin->status = StatusEnum::INACTIVE ;

        else
            $admin->status = StatusEnum::ACTIVE ;

        $admin->save();

        return $this->sendResponce(AdminResource::make($admin),
            'Admin updated successfully');
    }
}
