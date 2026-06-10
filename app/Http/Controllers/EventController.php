<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Partner;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $eventsQuery = Event::with('category')->latest();

        if ($request->filled('category')) {
            $slug = $request->query('category');
            $eventsQuery->whereHas('category', function ($query) use ($slug) {
                $query->where('slug', $slug);
            });
        }

        $events = $eventsQuery->get();
        $partners = Partner::orderBy('id', 'desc')->get();

        return view('welcome', compact('categories', 'events', 'partners'));
    }

    public function show(Event $event)
    {
        $categories = Category::all();

        $event->load('category');

        return view('event-detail', compact('categories', 'event'));
    }

    public function checkout(?Event $event = null)
    {
        $categories = Category::all();

        return view('checkout', compact('categories', 'event'));
    }
}
