<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\viewRecord;

class ViewProduct extends viewRecord
{
    protected static string $resource = ProductResource::class;
}
