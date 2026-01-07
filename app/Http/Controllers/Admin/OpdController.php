<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opd;
use Illuminate\Http\Request;

class OpdController extends Controller
{
    public function index(Request $request)
    {
        $query = Opd::withCount(['applications']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('kode', 'like', "%{$search}%")
                  ->orWhere('singkatan', 'like', "%{$search}%");
            });
        }

        $opdList = $query->orderBy('nama')->paginate(15);

        return view('admin.opd.index', compact('opdList'));
    }

    public function create()
    {
        return view('admin.opd.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:10|unique:opd,kode',
            'nama' => 'required|string|max:255',
            'singkatan' => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'website' => 'nullable|url|max:255',
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        Opd::create($validated);

        return redirect()->route('admin.opd.index')->with('success', 'OPD berhasil ditambahkan.');
    }

    public function edit(Opd $opd)
    {
        return view('admin.opd.edit', compact('opd'));
    }

    public function update(Request $request, Opd $opd)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:10|unique:opd,kode,' . $opd->id,
            'nama' => 'required|string|max:255',
            'singkatan' => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'website' => 'nullable|url|max:255',
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $opd->update($validated);

        return redirect()->route('admin.opd.index')->with('success', 'OPD berhasil diperbarui.');
    }

    public function destroy(Opd $opd)
    {
        // Check if OPD has applications
        if ($opd->applications()->count() > 0) {
            return back()->with('error', 'OPD tidak dapat dihapus karena masih memiliki aplikasi terkait.');
        }

        $opd->delete();

        return redirect()->route('admin.opd.index')->with('success', 'OPD berhasil dihapus.');
    }
}
