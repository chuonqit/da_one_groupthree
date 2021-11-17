<?php

namespace app\Http\Controllers\Admin;

use app\Options;
use app\Services\Request;
use database\DB;

class OptionController
{
    protected Options $options;

    public function __construct()
    {
        $this->options = new Options();
    }

    public function index(Request $request) {
        $options = $this->getOptions();
        if ($request->post()) {
            $input = $request->body();
            $logo = $request->file('logo');
            $favicon = $request->file('favicon');
            $options_data = [
                'app_name' => $input['app_name'],
                'hotline_1' => $input['hotline_1'],	
                'hotline_2' => $input['hotline_2'],	
                'hotline_3' => $input['hotline_3'],	
                'address' => $input['address'],	
                'email' => $input['email'],	
                'license' => $input['license'],	
                'is_maintenance' => $input['is_maintenance'],	
            ];
            if (empty($options)) {
                $image_logo = $request->hasFile('logo') ? upload_image($logo, 'options') : "";
                $image_favicon = $request->hasFile('favicon') ? upload_image($favicon, 'options') : "";
                $options_data['logo'] = $image_logo;
                $options_data['favicon'] = $image_favicon;
                DB::table('options')->insert($options_data)->save();
            } else {
                $image_logo = $request->hasFile('logo') ? upload_image($logo, 'options') : $options['logo'];
                $image_favicon = $request->hasFile('favicon') ? upload_image($favicon, 'options') : $options['favicon'];
                $options_data['logo'] = $image_logo;
                $options_data['favicon'] = $image_favicon;
                DB::table('options')->update($options_data)->where('option_id', '=', $input['option_id'])->save();
            }
            session_set('message', 'Cập nhật thành công');
            redirect('admin.options');
        }
        view('admin.options.update', [
            'options' => $options
        ]);
    }

    public function getMenuClient()
    {
        return $this->options->getMenuData();
    }

    public function getOptions()
    {
        return $this->options->getOptions();
    }
}