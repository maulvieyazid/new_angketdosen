<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HasilAngketController extends Controller
{
    function index()
    {
        return view('hasil-angket.index');
    }
}
