<?php

namespace app\Http\Controllers\Admin;

use app\Products;
use app\Categories;
use app\Brands;
use app\Services\Request;
use database\DB;

class ProductController
{
    protected Products $products;
    protected Categories $categories;
    protected Brands $brands;

    public function __construct()
    {
        $this->products = new Products();
        $this->categories = new Categories();
        $this->brands = new Brands();
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
        $categories = $this->categories->getCategoryChildren();
        $brands = $this->brands->getAllBrands();
        if ($request->post()) {
            $input = $request->body();
            $image = $request->file('product_image');
            $validate = $request->validate([
                'product_name' => 'required',
                'product_slug' => 'required',
                'product_description' => 'required',
                'product_price' => 'required',
                'product_quantity' => 'required',
                'category_id' => 'required',
                'brand_id' => 'required',
                'product_content' => 'required'
            ], [
                'product_name.required' => 'Vui lòng điền thông tin',
                'product_slug.required' => 'Vui lòng điền thông tin',
                'product_description.required' => 'Vui lòng điền thông tin',
                'product_price.required' => 'Vui lòng điền thông tin',
                'product_quantity.required' => 'Vui lòng điền thông tin',
                'category_id.required' => 'Vui lòng chọn thông tin',
                'brand_id.required' => 'Vui lòng chọn thông tin',
                'product_content.required' => 'Vui lòng điền thông tin'
            ]);

            if ($request->hasFile('product_image') == false) {
                $validate['product_image'][] = 'Vui chọn ảnh bìa sản phẩm';
            }

            if (empty($validate)) {
                $image_upload = upload_image($image, 'product');
                DB::table('products')->insert([
                    'product_name' => $input['product_name'],'product_slug' => $input['product_slug'],'product_description' => $input['product_description'],
                    'product_price' => $input['product_price'],'product_quantity' => $input['product_quantity'],'category_id' => $input['category_id'],
                    'brand_id' => $input['brand_id'],'product_content' => $input['product_content'],'is_variant' => $input['is_variant'],
                    'product_gifts' => $input['product_gifts'],'product_hot' => $input['product_hot'],'product_discount' => $input['product_discount'],
                    'product_image' => $image_upload
                ])->save();
                session_set('message', 'Thêm sản phẩm thành công');
                redirect('admin.product');
            }
        }
        view('admin.products.create', [
            'errors' => $validate,
            'categories' => $categories,
            'brands' => $brands
        ]);
    }

    public function update($id, Request $request)
    {
        $result = $this->products->getProductByID($id);
        $categories = $this->categories->getCategoryChildren();
        $brands = $this->brands->getAllBrands();
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
            'errors' => $validate,
            'categories' => $categories,
            'brands' => $brands
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