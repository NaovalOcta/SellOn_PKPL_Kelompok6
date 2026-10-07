## Functionality
### Larastan
- Penjelasan: Larastan adalah static analysis tool untuk Laravel yang membantu mendeteksi error pada kode Laravel sebelum dijalankan
- Cara Run: php vendor/bin/phpstan analyze 
- Report Error:
    Line   Http\Controllers\ProductController.php
    ------ -------------------------------------------------------------------------------------------------- 
    :218   Access to an undefined property App\Models\Product|Illuminate\Database\Eloquent\Collection<int,   
          App\Models\Product>::$image.
          🪪  property.notFound
          💡  Learn more: https://phpstan.org/blog/solving-phpstan-access-to-undefined-property
### PHP UNIT
- Cara run: php artisan test tests/Feature/ProductDeletionTest.php


## Maintanability