<?php

namespace App\Http\Controllers;

use App\Models\EventModel;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function register(Request $req, $eventId)
    {
        $event = EventModel::findOrFail($eventId);
        if (! $event->is_registration_open) {
            return back()->with('error', 'Pendaftaran event ditutup.');
        }
        $validated = $req->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'notes' => 'nullable|string',
        ]);
        if (EventRegistration::where('event_id', $eventId)->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'Anda sudah terdaftar pada event ini.');
        }
        EventRegistration::create([
            'event_id' => $eventId,
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Berhasil mendaftar event.');
    }

    public function registrations()
    {
        $registrations = EventRegistration::where('user_id', Auth::id())->with('event')->latest()->paginate(10);

        return view('events.registrations', compact('registrations'));
    }
}
