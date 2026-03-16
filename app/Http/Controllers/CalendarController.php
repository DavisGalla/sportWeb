<?php

namespace App\Http\Controllers;

use App\Services\GoogleCalendarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CalendarController extends Controller
{
    public function index()
    {
        $user = auth()->user();
    
        if (!$user->google_access_token) {
            return redirect('/auth/google')->with('error', 'Please connect your Google Calendar first.');
        }
    
        try {
            $service = new GoogleCalendarService($user);
            $events = $this->formatEvents($service->listEvents());
        } catch (\Exception $e) {
            Log::error('Calendar Error: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'exception' => $e
            ]);
            return back()->with('error', 'Failed to retrieve calendar events.');
        }
    
        return view('calendar.index', compact('events'));
    }
    
    private function formatEvents(array $rawEvents): array
    {
        return collect($rawEvents)->map(fn($e) => [
            'title' => $e->getSummary() ?? '(No title)',
            'start' => $e->getStart()->dateTime ?? $e->getStart()->date,
            'end'   => $e->getEnd()->dateTime ?? $e->getEnd()->date,
        ])->values()->toArray();
    }

    public function create()
    {
        return view('calendar.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user->google_access_token) {
            return redirect('/auth/google')->with('error', 'Please connect your Google Calendar first.');
        }

        $validated = $request->validate([
            'summary' => 'required|string',
            'description' => 'nullable|string',
            'start_time' => 'required|date_format:Y-m-d\TH:i',
            'end_time' => 'required|date_format:Y-m-d\TH:i|after:start_time',
        ]);

        try {
            $service = new GoogleCalendarService($user);
            $event = $service->createEvent(
                $validated['summary'],
                $validated['description'],
                $validated['start_time'],
                $validated['end_time']
            );

            return redirect()->route('calendar.index')->with('success', 'Event created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create event: ' . $e->getMessage());
        }
    }
}
