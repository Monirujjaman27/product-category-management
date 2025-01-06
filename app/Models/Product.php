<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model

{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the categories associated with the product.
     *
     * This function defines a many-to-many relationship between the Product
     * and Category models through the 'category_products' pivot table.
     * The 'product_id' column in the pivot table references the Product,
     * and the 'category_id' column references the Category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_products', 'product_id', 'category_id');
    }
}