<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Enums\RoleEnum;
use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admin\AdminPermissionRequest;
use App\Http\Resources\Admin\Admin\AdminResource;
use App\Http\Resources\Admin\Admin\PermissionResource;
use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends ApiController
{
    public function index(){
        $permissions = Permission::where('guard_name','admin')->paginate() ;
        return $this->sendResponce(PermissionResource::collection($permissions) ,
            'Permission retrieved successfully' ,
        200 ,
        true);
    }


    public function store(AdminPermissionRequest $request ,$admin_id){
        $currentAdminId = auth('admin')->id();

        $admin = Admin::where('id','!=',$currentAdminId)
            ->whereDoesntHave('roles',function($q){
                return $q->where('name',RoleEnum::SUPER_ADMIN->value);
            })
            ->findOrFail($admin_id);

        $admin->syncPermissions($request->permission_names);

        return $this->sendResponce(AdminResource::make($admin)
            ,'Permissions updated successfully');
    }
}
