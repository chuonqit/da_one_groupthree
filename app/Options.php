<?php

namespace app;

use database\DB;

class Options
{
    function getMenuData() 
    {
        return DB::table('categories')->select('*')->where('is_menu', '=', 1)->orderBy('category_index')->execute()->get();
    }

    function getOptions() 
    {
        return DB::table('options')->select('*')->execute()->first();
    }
}