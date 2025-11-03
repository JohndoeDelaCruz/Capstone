<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
    /**
     * Display the interactive map page.
     */
    public function index()
    {
        return view('farmers.map.index');
    }
}
