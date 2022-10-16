<?php

namespace App\Actions\Products;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductAction
{
    // save product to DB
    public function save(array $validatedData)
    {
        return DB::transaction(
            function () use ($validatedData) {
                $validatedData['user_id'] = auth()->id();

                return Product::create($validatedData);
            }
        );
    }

    // update product
    public function update(Product $product, array $validatedData)
    {
        return DB::transaction(
            function () use ($product, $validatedData) {
                return $product->update($validatedData);
            }
        );
    }

    // delete a product
    public function delete(Product $product)
    {
        return DB::transaction(
            function () use ($product): void {
                $product->delete();
            }
        );
    }
}
