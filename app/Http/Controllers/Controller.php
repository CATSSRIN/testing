<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}