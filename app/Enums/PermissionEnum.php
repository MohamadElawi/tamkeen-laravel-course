<?php

namespace App\Enums;

enum PermissionEnum : string
{
    case VIEW_CATEGORIES = 'view-categories' ;
    case CREATE_CATEGORIES = 'create-categories' ;
    case UPDATE_CATEGORIES = 'update-categories' ;
    case DELETE_CATEGORIES = 'delete-categories' ;
    case VIEW_PRODUCTS = 'view-products' ;
    case CREATE_PRODUCTS = 'create-products' ;
    case UPDATE_PRODUCTS = 'update-products' ;
    case DELETE_PRODUCTS = 'delete-products' ;
    case VIEW_ADMINS = 'view-admins' ;
    case CREATE_ADMINS = 'create-admins' ;
    case UPDATE_ADMINS = 'update-admins' ;
    case DELETE_ADMINS = 'delete-admins' ;
    case VIEW_USERS = 'view-users';

    public function guard(){
        return 'admin';
    }
}
