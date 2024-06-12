<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporatory;
use App\Models\ReservationLaporatory;

class ReservationlaporatoryController extends Controller
{
    public function store(Request $request)
    {
        $reservation = ReservationLaporatory::create($request->all());
        return response()->json($reservation, 201);
    }

    public function index()
    {
        return ReservationLaporatory::all();
    }

    public function show($id)
    {
        return ReservationLaporatory::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $reservation = ReservationLaporatory::findOrFail($id);
        $reservation->update(['state' => $request->state]); // تحديث الحقل 'state' فقط
        return response()->json($reservation, 200);
    }

    public function destroy($id)
    {
        ReservationLaporatory::findOrFail($id)->delete();
        return response()->json(null, 204);
    }

    public function showindoctor($id)
    {
        return Laporatory::with('reservationlaporatory')->find($id);
    }
}
