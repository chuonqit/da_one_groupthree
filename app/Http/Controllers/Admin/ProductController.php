<?php

namespace app\Http\Controllers\Admin;

use app\Products;
use app\Services\Request;

class ProductController
{
    protected Products $products;

    public function __construct()
    {
        $this->products = new Products();
    }

    public function index()
    {
        view('admin.products.list', [
            'products' => $this->products->listProduct()
        ]);
    }

    public function create(Request $request)
    {
        $validate = [];
        if ($request->post()) {
            $title = $request->input('title');
            $image = $request->file('image');
            $validate = $request->validate([
                'title' => 'required'
            ], [
                'title.required' => 'Vui long dien title'
            ]);

            if ($request->hasFile('image') == false) {
                $validate['image'][] = 'Vui long nhap anh';
            }

            if (empty($validate)) {
                $image_upload = upload_image($image, 'product');
                session_set('message', 'Thêm thành công '.$image_upload);
                redirect('admin.product');
            }
        }
        view('admin.products.create', [
            'errors' => $validate
        ]);
    }

    public function update($id, Request $request)
    {
        $result = $this->products->getProductByID($id);
        if (empty($result)) {
            error_page();
        }
        $validate = [];
        if ($request->post()) {
            $title = $request->input('title');
            $image = $request->file('image');

            $validate = $request->validate([
                'title' => 'required'
            ], [
                'title.required' => 'Vui long dien title'
            ]);

            if (empty($validate)) {
                $image_upload = 'IMG cũ.jpg';
                if ($request->hasFile('image')) {
                    $image_upload = upload_image($image, 'product');
                }
                session_set('message', 'Update thành công '. $image_upload);
                redirect('admin.product');
            }
        }
        view('admin.products.update', [
            'product' => $result,
            'errors' => $validate
        ]);
    }

    public function delete($id)
    {
        session_set('message', 'Xoá thành công');
        redirect('admin.product');
    }


    public function configuration(Request $request)
    {
        $product_id = $request->input('product_id');
        $config = $this->products->getProductConfiguration($product_id);
        view('admin.products.configuration', [
            'product_id' => $product_id,
            'config' => $config
        ]);
    }

    public function variant(Request $request)
    {
        $product_id = $request->input('product_id');
        $product_variants = $this->products->getListVariantByProductID($product_id);
        view('admin.products.variants.list', [
            'product_id' => $product_id,
            'variants' => $product_variants
        ]);
    }

    public function variantCreate(Request $request)
    {
        $product_id = $request->input('product_id');
        view('admin.products.variants.create', ['product_id' => $product_id]);
    }

    public function variantUpdate(Request $request)
    {
        $product_id = $request->input('product_id');
        $variant_id = $request->input('variant_id');
        $variants = $this->products->getListVariantByID($variant_id);
        view('admin.products.variants.update', [
            'product_id' => $product_id,
            'variants' => $variants
        ]);
    }

    public function variantDelete(Request $request)
    {
        $product_id = $request->input('product_id');
        session_set('message', 'Xoá thành công');
        redirect('admin.product.variant?product_id='.$product_id);
    }
}