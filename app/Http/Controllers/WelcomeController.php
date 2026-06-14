<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Event;

class WelcomeController extends Controller
{
    public function index()
    {
        $partners = Partner::where('is_active', true)
            ->orderBy('name')
            ->get();

        $events = Event::latest()->get();

        return view('welcome', compact('partners', 'events'));
    }
}