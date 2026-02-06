<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SopirRequest;
use App\Models\Sopir;

class SopirController extends Controller
{
    public function index()
    {
        $sopirs = Sopir::with('bus')->latest()->get();

        return view('admin.operasional.sopir.index', compact('sopirs'));
    }

    public function create()
    {
        return view('admin.operasional.sopir.create');
    }

    public function store(SopirRequest $request)
    {
        Sopir::create($request->validated());

        return redirect()->route('admin.operasional.sopir.index')
            ->with('success', 'Data sopir berhasil ditambahkan');
    }

    public function show(Sopir $sopir)
    {
        $sopir->load('bus.kategoriBus');

        return view('admin.operasional.sopir.show', compact('sopir'));
    }

    public function edit(Sopir $sopir)
    {
        return view('admin.operasional.sopir.edit', compact('sopir'));
    }

    public function update(SopirRequest $request, Sopir $sopir)
    {
        $sopir->update($request->validated());

        return redirect()->route('admin.operasional.sopir.index')
            ->with('success', 'Data sopir berhasil diperbarui');
    }

    public function destroy(Sopir $sopir)
    {
        if ($sopir->bus) {
            return back()->with('error', 'Sopir tidak dapat dihapus karena masih ditugaskan ke bus');
        }

        $sopir->delete();

        return redirect()->route('admin.operasional.sopir.index')
            ->with('success', 'Data sopir berhasil dihapus');
    }
}
