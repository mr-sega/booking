<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Inertia\Inertia;

class BookingPageController extends Controller
{
    public function index()
    {
        $bookings = Booking::latest()->get();

        return Inertia::render('Bookings/Index', [
            'bookings' => $bookings
        ]);
    }
}
