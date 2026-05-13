<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
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

        return view('welcome', compact('categories', 'events'));
    }

    public function show()
    {
        return view('event-detail');
    }

    public function checkout()
    {
        return view('checkout');
    }
}
