<?php

namespace App\Services\Product;

use App\Interfaces\Service\ProductServiceInterface;
use App\Models\Product;
use App\Repository\ProductImageRepository;
use App\Services\BaseService;

class ProductService extends BaseService implements ProductServiceInterface
{
    private ProductImageRepository $imageRepository;

    public function __construct(Product $model, ProductImageRepository $imageRepository)
    {
        $this->model = $model;
        $this->imageRepository = $imageRepository;
    }

    public function createProduct(): self
    {
        $this->model = $this->model->newQuery()->create([
            'name' => $this->getAttr('name'),
            'price' => $this->getAttr('price'),
            'category_id' => $this->getAttr('category_id'),
            'user_id' => auth()->id()
        ]);

        $this->saveDisplayImage();

        return $this;
    }

    public function manageDisplayImage()
    {
        $displayImage = $this->getAttr('display_image');

        if (!$displayImage) {
            return $this->model->display_image_id ?? '';
        }

        if ($this->model->display_image_id) {
            $this->imageRepository
                ->delete($this->model->display_image_id);
        }

        return $this->imageRepository
            ->save($this->model, $displayImage->store('product/image', 'public'));
    }

    public function updateProduct(): self
    {
        $this->model->update($this->getAttrs());
        $this->saveDisplayImage();

        return $this;
    }

    public function saveGalleryImages()
    {
        $galleryImage = $this->getAttr('gallery_image');

        if (!$galleryImage || $galleryImage == 'null' || !count($galleryImage)) {
            return;
        }

        foreach ($galleryImage as $image) {
            $this->imageRepository
                ->save($this->model, $image->store('product/image', 'public'));
        }
    }

    public function deleteProduct(): self
    {
        $this->model->load(['displayImage', 'images']);

        if ($this->model->displayImage) {
            $this->imageRepository->delete($this->model->displayImage->id);
        }

        if ($this->model->images && count($this->model->images)) {
            foreach ($this->model->images as $image){
                $this->imageRepository->delete($image->id);
            }
        }

        $this->model->delete();

        return $this;
    }

    public function saveDisplayImage(): self
    {
        $this->model->update([
            'display_image_id' => $this->manageDisplayImage()
        ]);

        return $this;
    }

    public function getPaginatedData()
    {
        return Product::query()
            ->with(['user:id,name', 'displayImage'])
            ->orderByDesc('id')
            ->paginate(10);
    }
}