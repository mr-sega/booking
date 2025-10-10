<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        return response()->json(Booking::query()->all());
    }

    public function store(StoreBookingRequest $request)
    {
        Booking::query()->create($request->validated());

        return redirect()->route('bookings.index')
            ->with('success', 'Booking created successfully!');
    }
}
