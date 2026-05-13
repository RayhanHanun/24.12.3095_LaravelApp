@extends('layouts.admin')

@section('title', 'Edit Partner - Admin')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-black mb-2">Edit Partner</h1>
        <p class="text-slate-500 font-medium">Perbarui data partner di bawah ini.</p>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8 max-w-2xl">
        <form action="{{ route('admin.partners.update', $partner->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-bold text-slate-700 mb-2">
                    Nama Partner <span class="text-red-600">*</span>
                </label>
                <input type="text" id="name" name="name"
                    class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-indigo-500 outline-none transition {{ $errors->has('name') ? 'border-red-500' : 'border-slate-200' }}"
                    placeholder="Masukkan nama partner" value="{{ old('name', $partner->name) }}">
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="logo_url" class="block text-sm font-bold text-slate-700 mb-2">
                    URL Logo <span class="text-red-600">*</span>
                </label>
                <input type="url" id="logo_url" name="logo_url"
                    class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-indigo-500 outline-none transition {{ $errors->has('logo_url') ? 'border-red-500' : 'border-slate-200' }}"
                    placeholder="https://contoh.com/logo.png" value="{{ old('logo_url', $partner->logo_url) }}">
                <p class="text-xs text-slate-400 mt-1">Contoh: https://placehold.co/200x200</p>
                @error('logo_url')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-6 flex gap-4">
                <a href="{{ route('admin.partners.index') }}"
                    class="px-6 py-3 border-2 border-slate-200 rounded-xl font-bold text-slate-700 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold shadow-lg hover:bg-indigo-700 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
