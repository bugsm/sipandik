<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Opd;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = Application::with('opd');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('url', 'like', "%{$search}%");
            });
        }

        if ($request->filled('platform')) {
            $query->where('platform', $request->platform);
        }

        $applications = $query->orderBy('nama')->paginate(15);

        return view('admin.applications.index', compact('applications'));
    }

    public function create()
    {
        $opdList = Opd::where('is_active', true)->orderBy('nama')->get();
        return view('admin.applications.create', compact('opdList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'opd_id' => 'required|uuid|exists:opd,id',
            'nama' => 'required|string|max:255',
            'versi' => 'nullable|string|max:20',
            'url' => 'nullable|url|max:255',
            'deskripsi' => 'nullable|string',
            'platform' => 'required|in:web,mobile,desktop,api',
            'pic_nama' => 'nullable|string|max:100',
            'pic_telepon' => 'nullable|string|max:20',
            'pic_email' => 'nullable|email|max:100',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        Application::create($validated);

        return redirect()->route('admin.applications.index')->with('success', 'Aplikasi berhasil ditambahkan.');
    }

    public function edit(Application $application)
    {
        $opdList = Opd::where('is_active', true)->orderBy('nama')->get();
        return view('admin.applications.edit', compact('application', 'opdList'));
    }

    public function update(Request $request, Application $application)
    {
        $validated = $request->validate([
            'opd_id' => 'required|uuid|exists:opd,id',
            'nama' => 'required|string|max:255',
            'versi' => 'nullable|string|max:20',
            'url' => 'nullable|url|max:255',
            'deskripsi' => 'nullable|string',
            'platform' => 'required|in:web,mobile,desktop,api',
            'pic_nama' => 'nullable|string|max:100',
            'pic_telepon' => 'nullable|string|max:20',
            'pic_email' => 'nullable|email|max:100',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $application->update($validated);

        return redirect()->route('admin.applications.index')->with('success', 'Aplikasi berhasil diperbarui.');
    }

    public function destroy(Application $application)
    {
        // Check if application has bug reports
        if ($application->bugReports()->count() > 0) {
            return back()->with('error', 'Aplikasi tidak dapat dihapus karena masih memiliki laporan bug terkait.');
        }

        $application->delete();

        return redirect()->route('admin.applications.index')->with('success', 'Aplikasi berhasil dihapus.');
    }
}
