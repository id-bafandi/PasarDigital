<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        // Sementara tampilkan halaman kosong dulu
        return view('cart.index');
    }
}