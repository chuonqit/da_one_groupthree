<?php

namespace app;

use database\DB;

class Categories
{
    public function getProductCategoryBySlug($slug, $request) 
    {
        $data = DB::table('products P')->select("concat(C.category_name, ' ', P.product_name) as product_full_name",
            "concat(C.category_slug, '-', P.product_slug) as product_full_slug",
            'P.*', 'PC.*', 'B.brand_name',' B.brand_slug', 'C.category_name as cate_child_name', 
            'C.category_slug as cate_child_slug', 'CParent.category_name as cate_parent_name', 'CParent.category_slug as cate_parent_slug')
            ->leftJoin('product_configuration PC', 'PC.product_id', '=', 'P.product_id')
            ->leftJoin('brands B', 'B.brand_id', '=', 'P.brand_id')
            ->leftJoin('categories C','C.category_id', '=', 'P.category_id')
            ->leftJoin('categories CParent','C.parent_id', '=', 'CParent.category_id')
            ->where('CParent.category_slug', '=', $slug);
        if ($request->input('brand')) {
            $data->where('B.brand_slug', '=', $request->input('brand'));
        }
        return $data->execute()->get();
    }

    public function getAllProduct($request)
    {
        $data = DB::table('products P')->select("concat(C.category_name, ' ', P.product_name) as product_full_name",
            "concat(C.category_slug, '-', P.product_slug) as product_full_slug",
            'P.*', 'PC.*', 'B.brand_name',' B.brand_slug', 'C.category_name as cate_child_name', 
            'C.category_slug as cate_child_slug', 'CParent.category_name as cate_parent_name', 'CParent.category_slug as cate_parent_slug')
            ->leftJoin('product_configuration PC', 'PC.product_id', '=', 'P.product_id')
            ->leftJoin('brands B', 'B.brand_id', '=', 'P.brand_id')
            ->leftJoin('categories C','C.category_id', '=', 'P.category_id')
            ->leftJoin('categories CParent','C.parent_id', '=', 'CParent.category_id');
        if ($request->input('brand')) {
            $data->where('B.brand_slug', '=', $request->input('brand'));
        }
        return $data->execute()->get();
    }

    function getCategoryChildren() 
    {
        return DB::table('categories')->select('*')->where('is_parent', '=', 0)->execute()->get();
    }

    public function getCategoryTitle($slug) 
    {
        if (empty($slug)) {
            $data = DB::table('categories')->select('*')->where('category_slug', '=', $slug)->execute()->first();
            return $data['category_name'];
        } 
        return "Danh mục";
    }
}