@extends('layouts.admin')

@section('title', 'Detail Event - Admin')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-black mb-2">Detail Event</h1>
            <p class="text-slate-500 font-medium">Ringkasan informasi acara.</p>
        </div>
        <a href="{{ route('admin.events.index') }}"
            class="px-6 py-3 border-2 border-slate-200 rounded-xl font-bold text-slate-700 hover:bg-slate-50 transition">
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="space-y-4">
                <h2 class="text-2xl font-black text-slate-800">{{ $event->title }}</h2>
                <p class="text-slate-500">{{ $event->description }}</p>
                <div class="text-sm text-slate-500 space-y-2">
                    <p><span class="font-bold text-slate-700">Kategori:</span> {{ $event->category->name ?? '-' }}</p>
                    <p><span class="font-bold text-slate-700">Tanggal:</span> {{ $event->date }}</p>
                    <p><span class="font-bold text-slate-700">Lokasi:</span> {{ $event->location }}</p>
                </div>
            </div>
            <div class="space-y-4">
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                    <p class="text-sm text-slate-500">Harga</p>
                    <p class="text-3xl font-black text-indigo-600">Rp {{ number_format($event->price, 0, ',', '.') }}</p>
                </div>
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                    <p class="text-sm text-slate-500">Stok</p>
                    <p class="text-3xl font-black text-slate-800">{{ $event->stock }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
