<?php

namespace App\Http\Controllers;

use App\Models\Partner;

class WelcomeController extends Controller
{
    public function index()
    {
        $partners = Partner::where('is_active', true)->orderBy('name')->get();
        return view('welcome', compact('partners'));
    }
}

