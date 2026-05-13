<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::all();
        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'logo_url' => 'required|string|url',
        ]);

        Partner::create($data);

        return redirect()->route('admin.partners.index')->with('success', 'Data Partner berhasil ditambahkan.');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'logo_url' => 'required|string|url',
        ]);

        $partner->update($data);

        return redirect()->route('admin.partners.index')->with('success', 'Data Partner berhasil diperbarui.');
    }

    public function destroy(Partner $partner)
    {
        Partner::whereKey($partner->id)->delete();

        return redirect()->route('admin.partners.index')->with('success', 'Data Partner berhasil dihapus.');
    }
}
