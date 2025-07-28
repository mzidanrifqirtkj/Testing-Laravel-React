<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Products/index', []);
    }

    public function create()
    {
        return Inertia::render('Products/create', []);
    }
}
