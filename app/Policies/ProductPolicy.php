<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Admin;
use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool   // index
    {
        return $user->hasPermissionTo(PermissionEnum::VIEW_PRODUCTS);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view( $user, Product $product): bool  // view
    {
        return $user->hasPermissionTo(PermissionEnum::VIEW_PRODUCTS);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create( $user): bool
    {
        return $user->hasPermissionTo(PermissionEnum::CREATE_PRODUCTS);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update( $user, Product $product): bool
    {
        return $user->hasPermissionTo(PermissionEnum::UPDATE_PRODUCTS);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete( $user, Product $product): bool
    {
        return $user->hasPermissionTo(PermissionEnum::DELETE_PRODUCTS);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore( $user, Product $product): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete( $user, Product $product): bool
    {
        return true;
    }

    public function deleteAny( $user): bool
    {
        return true;
    }


}
