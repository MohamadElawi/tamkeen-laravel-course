# Translatable Search with Spatie Laravel Translatable

This document explains how to search across all languages in translatable fields using Spatie Laravel Translatable.

## Overview

The application now supports searching across all languages in translatable fields (`name` and `description`) for products. This is implemented using a custom scope method in the Product model.

## Implementation

### 1. Product Model Scope

A new scope method `searchTranslatable` has been added to the `Product` model:

```php
public function scopeSearchTranslatable($query, $search)
{
    if (empty($search)) {
        return $query;
    }

    return $query->where(function($q) use ($search) {
        // Get all available locales from config
        $locales = config('app.locales', ['en', 'ar']);
        
        foreach ($this->translatable as $field) {
            foreach ($locales as $locale) {
                $q->orWhere("$field->$locale", 'like', '%' . $search . '%');
            }
        }
    });
}
```

### 2. Configuration

The supported locales are defined in `config/app.php`:

```php
'locales' => ['en', 'ar'],
```

### 3. Usage Examples

#### API Route Usage

```php
// Search across all languages
GET /api/test-api?search=your_search_term

// This will search in:
// - name->en
// - name->ar  
// - description->en
// - description->ar
```

#### Controller Usage

```php
// In ProductController
public function index(Request $request)
{
    $products = Product::searchTranslatable($request->search)
        ->with('categories')
        ->paginate();
    
    return $this->sendResponse(
        ProductResource::collection($products),
        __('Products_retrieved_successfully'),
        200,
        true
    );
}
```

#### Direct Model Usage

```php
// Search for products with "phone" in any language
$products = Product::searchTranslatable('phone')->get();

// Search for products with "هاتف" in Arabic
$products = Product::searchTranslatable('هاتف')->get();

// Combine with other conditions
$products = Product::searchTranslatable('phone')
    ->where('status', StatusEnum::ACTIVE)
    ->with('categories')
    ->get();
```

## How It Works

1. **Dynamic Locale Detection**: The scope automatically detects available locales from the config
2. **Translatable Field Detection**: It uses the `$translatable` property from the model
3. **JSON Column Search**: Uses Laravel's JSON column operators (`->`) to search within JSON fields
4. **OR Conditions**: Combines all language searches with OR conditions

## Database Structure

The translatable fields are stored as JSON in the database:

```json
{
  "name": {
    "en": "Smartphone",
    "ar": "هاتف ذكي"
  },
  "description": {
    "en": "Latest smartphone model",
    "ar": "أحدث نموذج هاتف ذكي"
  }
}
```

## Adding New Languages

To add support for new languages:

1. Add the locale to `config/app.php`:
```php
'locales' => ['en', 'ar', 'fr', 'es'],
```

2. Update your factories to include the new language:
```php
'name' => [
    'en' => $enFaker->words(2, true),
    'ar' => $arFaker->words(2, true),
    'fr' => $frFaker->words(2, true),
    'es' => $esFaker->words(2, true),
],
```

The search scope will automatically include the new language without any code changes.

## Performance Considerations

- The search uses `LIKE` queries which can be slow on large datasets
- Consider adding database indexes on translatable JSON columns for better performance
- For production use, consider implementing full-text search with Elasticsearch or similar

## Testing

You can test the search functionality using the API route:

```bash
# Search in English
curl "http://your-app.com/api/test-api?search=phone"

# Search in Arabic  
curl "http://your-app.com/api/test-api?search=هاتف"

# Search in products API
curl "http://your-app.com/api/products?search=phone"
``` 