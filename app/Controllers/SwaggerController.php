<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class SwaggerController extends Controller
{
    public function index()
    {
        return view('swagger_view');
    }
}
