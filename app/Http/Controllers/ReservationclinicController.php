<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clinic;
use App\Models\ReservationClinic;
class ReservationclinicController extends Controller
{
    public function store(Request $request)
    {
        $reservation = ReservationClinic::create($request->all());
        return response()->json($reservation, 201);
    }

    public function index()
    {
        return ReservationClinic::all();
    }

    public function show($id)
    {
        return ReservationClinic::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $course = ReservationClinic::findOrFail($id);
        $course->update($request->all());
        return response()->json($course, 200);
    }

    public function destroy($id)
    {
        ReservationClinic::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
    public function showindoctor($id)
    {
        return Clinic::with('reservationclinic')->find($id);
    }
}
