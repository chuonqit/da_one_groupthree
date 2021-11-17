<?php

namespace app\Http;

class Controller
{
    public function __construct()
    {
    }

    public function isLogin()
    {
        if (empty(auth)) {
            redirect('account.login');
        }
    }

    public function isMaintenance() {
        if (!empty(getOptions())) {
            if (getOptions()['is_maintenance'] == 1) {
                view('maintenance');
                die;
            }
        }
    }
}