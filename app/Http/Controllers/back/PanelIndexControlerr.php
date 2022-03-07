<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PanelIndexControlerr extends Controller
{
    public function index()
    {
        return view('back.index');
    }
}
