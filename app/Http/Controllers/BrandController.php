<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount('products')
            ->latest()
            ->get();

        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_merek' => 'required|string|max:255',
        ]);

        $validated['negara_asal'] = '-';

        Brand::create($validated);

        return redirect()
            ->route('brands.index')
            ->with('success', 'Merek berhasil ditambahkan.');
    }

    public function show(Brand $brand)
    {
        $brand->load('products');

        return view('admin.brands.show', compact('brand'));
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $data = $request->validate([
            'nama_merek' => 'required|string|max:255',
        ]);

        $data['negara_asal'] = '-';
         
        $brand->update($data);

        return redirect()
            ->route('brands.index')
            ->with('success', 'Merek berhasil diperbarui.');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()
            ->route('brands.index')
            ->with('success', 'Merek berhasil dihapus.');
    }
}