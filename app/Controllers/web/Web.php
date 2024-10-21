<?php

namespace App\Controllers\web;

use App\Controllers\BaseController;

class Web extends BaseController
{
    public function index()
    {
        return view('/web/index');
    }
}
