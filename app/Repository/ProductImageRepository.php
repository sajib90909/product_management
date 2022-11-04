<?php

namespace App\Repository;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductImageRepository
{
    public function save(Product $product, $path)
    {
        $productImage = ProductImage::query()->create([
            'alter_name' => 'product image',
            'url' => $path,
            'product_id' => $product->id
        ]);

        return optional($productImage)->id;
    }

    public function get($id)
    {
        return ProductImage::query()->find($id);
    }

    public function delete($imageId): bool
    {
        $imageModel = $this->get($imageId);

        if ($imageModel) {
            Storage::delete($imageModel->url);
            $imageModel->delete();
        }

        return true;
    }
}