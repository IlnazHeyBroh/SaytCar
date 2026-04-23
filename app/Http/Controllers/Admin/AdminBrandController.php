<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bb;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminBrandController extends Controller
{
    public function index()
    {
        return view('admin.brands.index', [
            'brands' => Brand::orderBy('name')->get()->map(function (Brand $brand) {
                $brand->cars_count = Bb::where('brand', $brand->name)->count();
                return $brand;
            }),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:brands,name'],
        ]);

        Brand::create([
            'name' => $validated['name'],
        ]);

        return redirect()->route('admin.brands.index')->with('success', 'Марка добавлена.');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', [
            'brand' => $brand,
        ]);
    }

    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('brands', 'name')->ignore($brand->id)],
        ]);

        $oldName = $brand->name;
        $brand->update([
            'name' => $validated['name'],
        ]);

        if ($oldName !== $brand->name) {
            Bb::where('brand', $oldName)->update(['brand' => $brand->name]);
        }

        return redirect()->route('admin.brands.index')->with('success', 'Марка обновлена.');
    }

    public function destroy(Brand $brand)
    {
        if (Bb::where('brand', $brand->name)->exists()) {
            return redirect()->route('admin.brands.index')->with('success', 'Эту марку нельзя удалить, пока она используется в объявлениях.');
        }

        $brand->delete();

        return redirect()->route('admin.brands.index')->with('success', 'Марка удалена.');
    }
}
