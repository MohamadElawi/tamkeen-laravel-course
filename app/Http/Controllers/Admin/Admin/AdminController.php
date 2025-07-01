<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
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
            new Middleware('permission:'.PermissionEnum::CREATE_ADMINS->value ,only: ['store']),
//            new Middleware('permission:'.PermissionEnum::VIEW_ADMINS->value ,only: ['index','show']),
        ];
    }


    public function index(Request $request){
        $currentAdminId = auth('admin')->id();
        $admins = Admin::where('id','!=',$currentAdminId)
            ->with('roles','permissions')
            ->paginate($request->count); // by default 15;

        return $this->sendResponce(AdminResource::collection($admins),
                'Admins retrieved successfully',
                '200',
            true);
    }


    public function store(AdminRequest $request){
        $data = $request->validated();

        // create a new admin
        $admin = Admin::create($data);

        // assign the admin role to the new admin
        $admin->assignRole(RoleEnum::ADMIN);

        return $this->sendResponce(AdminResource::make($admin) ,'Admin created successfully');
    }

    public function show($id){
        $admin = Admin::with(['roles','permissions'])->findOrFail($id);

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
