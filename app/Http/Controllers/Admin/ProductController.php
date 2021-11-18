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
            $input['product_gifts'] = implode(',', $input['product_gifts']);
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
            $input = $request->body();
            $image = $request->file('product_image');
            $input['product_gifts'] = implode(',', $input['product_gifts']);
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

            if (empty($validate)) {
                $image_upload = $result['product_image'];
                if ($request->hasFile('product_image')) {
                    $image_upload = upload_image($image, 'product');
                }
                DB::table('products')->update([
                    'product_name' => $input['product_name'],'product_slug' => $input['product_slug'],'product_description' => $input['product_description'],
                    'product_price' => $input['product_price'],'product_quantity' => $input['product_quantity'],'category_id' => $input['category_id'],
                    'brand_id' => $input['brand_id'],'product_content' => $input['product_content'],'is_variant' => $input['is_variant'],
                    'product_gifts' => $input['product_gifts'],'product_hot' => $input['product_hot'],'product_discount' => $input['product_discount'],
                    'product_image' => $image_upload, 'updated_at' => date('Y-m-d H:i:s')
                ])->where('product_id', '=', $input['product_id'])->save();
                session_set('message', 'Cập nhật thành công');
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
        DB::table('products')->delete('product_id', $id);
        session_set('message', 'Xoá thành công');
        redirect('admin.product');
    }


    public function configuration($pid, Request $request)
    {
        $config = $this->products->getProductConfiguration($pid);
        if ($request->post()) {
            $input = $request->body();
            $product_configuration = DB::table('product_configuration');
            $data_configuration = [
                'display' => $input['display'],
                'camera_front' => $input['camera_front'],
                'camera_back' => $input['camera_back'],
                'ram' => $input['ram'],
                'storage' => $input['storage'],
                'cpu' => $input['cpu'],
                'gpu' => $input['gpu'],
                'battery' => $input['battery'],
                'sim' => $input['sim'],
                'system' => $input['system'],
                'made_in' => $input['made_in']
            ];
            if (empty($config)) {
                $data_configuration['product_id'] = $input['product_id'];
                $product_configuration->insert($data_configuration)->save();
            } else {
                $product_configuration->update($data_configuration)->where('product_id', '=', $input['product_id'])->save();
            }
            session_set('message', 'Cập nhật thành công');
            redirect('admin.product');
        }
        view('admin.products.configuration', [
            'product_id' => $pid,
            'config' => $config
        ]);
    }

    public function variant(Request $request)
    {
        $pid = $request->input('product_id');
        $product_variants = $this->products->getListVariantByProductID($pid);
        view('admin.products.variants.list', [
            'product_id' => $pid,
            'variants' => $product_variants
        ]);
    }

    public function variantCreate($pid, Request $request)
    {
        $validate = [];
        if ($request->post()) {
            $input = $request->body();
            $image = $request->file('product_variant_image');
            $validate = $request->validate([
                'product_variant_name' => 'required',
                'product_variant_slug' => 'required',
                'product_variant_price' => 'required',
            ], [
                'product_variant_name.required' => 'Vui lòng điền thông tin',
                'product_variant_slug.required' => 'Vui lòng điền thông tin',
                'product_variant_price.required' => 'Vui lòng điền thông tin',
            ]);

            if ($request->hasFile('product_variant_image') == false) {
                $validate['product_variant_image'][] = 'Vui chọn ảnh bìa sản phẩm';
            }

            if (empty($validate)) {
                $image_upload = upload_image($image, 'product');
                DB::table('product_variants')->insert([
                    'product_variant_name' => $input['product_variant_name'],'product_variant_slug' => $input['product_variant_slug'], 
                    'product_variant_price' => $input['product_variant_price'],'product_variant_discount' => $input['product_variant_discount'],
                    'product_variant_image' => $image_upload, 'product_id' => $input['product_id']
                ])->save();
                session_set('message', 'Thêm biến thể thành công');
                redirect('admin.product.variant?product_id='.$input['product_id']);
            }
        }
        view('admin.products.variants.create', [
            'product_id' => $pid,
            'errors' => $validate
        ]);
    }

    public function variantUpdate($vid, $pid, Request $request)
    {
        $validate = [];
        $variants = $this->products->getListVariantByID($vid);
        if ($request->post()) {
            $input = $request->body();
            $image = $request->file('product_variant_image');
            $validate = $request->validate([
                'product_variant_name' => 'required',
                'product_variant_slug' => 'required',
                'product_variant_price' => 'required',
            ], [
                'product_variant_name.required' => 'Vui lòng điền thông tin',
                'product_variant_slug.required' => 'Vui lòng điền thông tin',
                'product_variant_price.required' => 'Vui lòng điền thông tin',
            ]);

            if (empty($validate)) {
                $image_upload = $variants['product_variant_image'];
                if ($request->hasFile('product_variant_image')) {
                    $image_upload = upload_image($image, 'product');
                }
                DB::table('product_variants')->update([
                    'product_variant_name' => $input['product_variant_name'],'product_variant_slug' => $input['product_variant_slug'], 
                    'product_variant_price' => $input['product_variant_price'],'product_variant_discount' => $input['product_variant_discount'],
                    'product_variant_image' => $image_upload, 'product_id' => $input['product_id']
                ])->where('product_variant_id', '=', $input['product_variant_id'])->save();
                session_set('message', 'Cập nhật biến thể thành công');
                redirect('admin.product.variant?product_id='.$input['product_id']);
            }
        }
        view('admin.products.variants.update', [
            'product_id' => $pid,
            'variants' => $variants,
            'errors' => $validate
        ]);
    }

    public function variantDelete($vid, $pid, Request $request)
    {
        DB::table('product_variants')->delete('product_variant_id', $vid);
        session_set('message', 'Xoá thành công');
        redirect('admin.product.variant?product_id='.$pid);
    }
}