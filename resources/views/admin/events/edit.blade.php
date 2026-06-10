@extends('layouts.admin')
@section('title', 'Edit Event - Admin')
@section('page_title', 'Edit Event')
@section('page_subtitle', 'Ubah detail acara.')

@section('content')
    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm
max-w-3xl">
        <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">

            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="mb-6 rounded-xl bg-red-100 text-red-700 p-4 text-sm font-semibold">
                    <p class="font-bold mb-2">Data gagal disimpan</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase

tracking-wide">Judul Event</label>

                <input type="text" name="title" value="{{ old('title', $event->title) }}"
                    class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100
rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600
outline-none transition font-medium"
                    required>

                @error('title')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase

tracking-wide">Kategori</label>

                <select name="category_id"
                    class="w-full px-5 py-4 bg-slate-50
border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10
focus:border-indigo-600 outline-none transition font-medium"
                    required>

                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $event->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}</option>
                    @endforeach
                </select>

                @error('category_id')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase

tracking-wide">Deskripsi</label>

                <textarea name="description" rows="4"
                    class="w-full px-5 py-4
bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4
focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition
font-medium">{{ old('description', $event->description) }}</textarea>

                @error('description')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>

                    <label class="block text-sm font-bold text-slate-700 mb-2

uppercase tracking-wide">Tanggal &
                        Waktu</label>

                    <input type="datetime-local" name="date"
                        value="{{ old('date', $event->date->format('Y-m-d\TH:i')) }}"
                        class="w-full px-5 py-4 bg-slate-50
border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10
focus:border-indigo-600 outline-none transition font-medium"
                        required>

                    @error('date')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror

                </div>
                <div>

                    <label class="block text-sm font-bold text-slate-700 mb-2

uppercase tracking-wide">Lokasi</label>

                    <input type="text" name="location" value="{{ old('location', $event->location) }}"
                        class="w-full px-5 py-4 bg-slate-50 border-2
border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10
focus:border-indigo-600 outline-none transition font-medium"
                        required>

                    @error('location')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror

                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>

                    <label class="block text-sm font-bold text-slate-700 mb-2

uppercase tracking-wide">Harga (Rp)</label>

                    <input type="number" name="price" value="{{ old('price', $event->price) }}"
                        class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100
rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600
outline-none transition font-medium"
                        required min="0">

                    @error('price')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror

                </div>
                <div>

                    <label class="block text-sm font-bold text-slate-700 mb-2

uppercase tracking-wide">Kapasitas
                        (Stok)</label>

                    <input type="number" name="stock" value="{{ old('stock', $event->stock) }}"
                        class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600
outline-none transition font-medium"
                        required min="1">

                    @error('stock')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror

                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase

tracking-wide">Poster Event
                    (Opsional)</label>

                @if ($event->poster_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($event->poster_path))
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $event->poster_path) }}" alt="{{ $event->title }}"
                            class="w-24 h-32 rounded-xl object-cover shadow-sm">
                        <p class="text-sm text-slate-500 mt-1">Poster saat ini</p>
                    </div>
                @endif

                <input type="file" name="poster" accept="image/*"
                    class="w-full px-5
py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4
focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition
font-medium">

                @error('poster')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="pt-4 flex justify-end gap-4 border-t border-slate-100">
                <a href="{{ route('admin.events.index') }}"
                    class="px-6 py-4

text-slate-500 font-bold hover:text-slate-800 transition">Batal</a>

                <button type="submit"
                    class="px-8 py-4 bg-indigo-600 text-white
rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700
transition">Simpan
                    Perubahan</button>
            </div>
        </form>
    </div>
@endsection
