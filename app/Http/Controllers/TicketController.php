<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Menampilkan halaman ticket
     */
    public function index()
    {
        return view('ticket');
    }
}
