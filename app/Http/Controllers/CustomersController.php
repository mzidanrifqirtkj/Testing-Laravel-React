<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomersController extends Controller
{
    public function index()
    {
        return Inertia::render("Customers/index", []);
    }
}
