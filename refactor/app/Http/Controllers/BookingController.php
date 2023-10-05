<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\BookingRepository;

class BookingController extends Controller
{
    protected $bookingRepository;

    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function createBooking(Request $request)
    {
        $data = $request->all();

        if (!$this->validateBookingData($data)) {
            return response()->json(['error' => 'user_id and event_id are required'], 400);
        }

        $booking = $this->bookingRepository->create($data);

        if ($booking) {
            return response()->json(['message' => 'Booking created successfully'], 201);
        }

        return response()->json(['error' => 'Failed to create booking'], 500);
    }

    public function getBooking($id)
    {
        $booking = $this->bookingRepository->find($id);

        if ($booking) {
            return response()->json(['data' => $booking], 200);
        }

        return response()->json(['error' => 'Booking not found'], 404);
    }

    public function deleteBooking($id)
    {
        $deleted = $this->bookingRepository->delete($id);

        if ($deleted) {
            return response()->json(['message' => 'Booking deleted successfully'], 200);
        }

        return response()->json(['error' => 'Failed to delete booking'], 500);
    }

    protected function validateBookingData($data)
    {
        return isset($data['user_id']) && isset($data['event_id']);
    }
}

