<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function create(Event $event)
    {
        $categories = Category::all();

        return view('checkout.create', compact('event', 'categories'));
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ], [
            'customer_name.required' => 'Nama lengkap wajib diisi.',
            'customer_email.required' => 'Email aktif wajib diisi.',
            'customer_email.email' => 'Format email tidak valid.',
            'customer_phone.required' => 'Nomor WhatsApp wajib diisi.',
        ]);

        if ($event->stock <= 0) {
            return back()
                ->with('error', 'Mohon maaf, tiket untuk acara ini sudah habis.')
                ->withInput();
        }

        $orderId = 'TRX-' . time() . '-' . Str::upper(Str::random(5));
        $totalPrice = $event->price + 5000;

        Transaction::create([
            'event_id' => $event->id,
            'order_id' => $orderId,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        return redirect('/')->with('success', 'Pesanan berhasil dibuat. Silakan lanjutkan pembayaran.');
    }
}
