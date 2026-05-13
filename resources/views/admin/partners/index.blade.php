@extends('layouts.admin')

@section('title', 'Kelola Partner - Admin')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-black mb-2">Daftar Partner</h1>
            <p class="text-slate-500 font-medium">Kelola semua partner yang terhubung dengan platform.</p>
        </div>
        <a href="{{ route('admin.partners.create') }}"
            class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg hover:bg-indigo-700 transition">
            + Tambah Partner
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                    <tr>
                        <th class="px-8 py-4">No</th>
                        <th class="px-8 py-4">Logo</th>
                        <th class="px-8 py-4">Nama Partner</th>
                        <th class="px-8 py-4">URL Logo</th>
                        <th class="px-8 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-t">
                    @forelse ($partners as $partner)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-8 py-6">
                                <span class="font-bold text-slate-900">{{ $loop->iteration }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}"
                                    class="w-16 h-16 rounded-lg object-cover border border-slate-200">
                            </td>
                            <td class="px-8 py-6">
                                <p class="font-bold text-slate-800">{{ $partner->name }}</p>
                            </td>
                            <td class="px-8 py-6">
                                <p class="text-xs text-slate-500 font-mono break-all">
                                    {{ Str::limit($partner->logo_url, 50) }}</p>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex gap-2">
                                    <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus partner ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.partners.edit', $partner->id) }}"
                                        class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center text-slate-400">
                                <p class="text-lg font-medium">Belum ada data partner</p>
                                <p class="text-sm mt-2">Klik tombol "Tambah Partner" untuk membuat yang baru</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
