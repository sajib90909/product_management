<?php

namespace App\Http\Controllers\API\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\Product\ProductService;

class ProductController extends Controller
{
    private ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response(
            $this->service
                ->getPaginatedData()
        );
    }

    public function get(Product $product)
    {
        return response(
            $product->load(['user', 'images', 'displayImage', 'images', 'category'])
        );
    }

    public function create(ProductRequest $request)
    {
        $this->service
            ->setAttrs($request->all())
            ->createProduct()
            ->saveGalleryImages();

        return response([
            'status' => 'success',
            'message' => 'Product created successfully',
            'payload' => $this->service->getModel()
        ]);
    }

    public function update(Product $product, ProductRequest $request)
    {
        $this->service
            ->setAttrs($request->all())
            ->setModel($product)
            ->updateProduct();

        return response([
            'status' => 'success',
            'message' => 'Product updated successfully',
            'payload' => $this->service->getModel()
        ]);
    }

    public function delete(Product $product)
    {
        $this->service
            ->setModel($product)
            ->deleteProduct();

        return response(['status' => 'success', 'message' => 'Product deleted successfully']);
    }
}
