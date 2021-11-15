<?php

namespace app;

use database\DB;

class Brands
{
    function getAllBrands() 
    {
        return DB::table('brands')->select('*')->execute()->get();
    }
}