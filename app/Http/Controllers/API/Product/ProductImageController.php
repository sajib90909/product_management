<?php

namespace App\Http\Controllers\API\Product;

use App\Http\Controllers\Controller;
use App\Repository\ProductImageRepository;

class ProductImageController extends Controller
{
    private ProductImageRepository $repository;

    public function __construct(ProductImageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function delete($id)
    {
        $this->repository->delete($id);

        return response(['status' => 'success', 'message' => 'Image deleted successfully']);
    }
}