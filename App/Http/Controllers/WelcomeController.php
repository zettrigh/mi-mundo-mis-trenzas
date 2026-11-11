<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Service;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    /**
     * Display the home page with services catalog and reviews.
     */
    public function welcome(): View
    {
        $services = Service::where('is_active', true)
            ->orderBy('id')
            ->get();

        $reviews = Review::with(['client', 'stylist', 'appointment.service'])
            ->where('rating', '>=', 4)
            ->latest()
            ->take(3)
            ->get();

        return view('welcome', compact('services', 'reviews'));
    }
}
