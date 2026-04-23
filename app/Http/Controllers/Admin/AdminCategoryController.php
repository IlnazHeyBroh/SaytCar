<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;

class AdminCategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index', [
            'categories' => Category::listingTypes()->withCount('bbs')->get(),
        ]);
    }

    public function store()
    {
        return redirect()->route('admin.categories.index')->with('success', 'Доступны только две фиксированные категории: Новые и С пробегом.');
    }

    public function edit(Category $category)
    {
        return redirect()->route('admin.categories.index')->with('success', 'Категории фиксированные и не редактируются из админки.');
    }

    public function update(Category $category)
    {
        return redirect()->route('admin.categories.index')->with('success', 'Категории фиксированные и не редактируются из админки.');
    }

    public function destroy(Category $category)
    {
        return redirect()->route('admin.categories.index')->with('success', 'Удаление фиксированных категорий отключено.');
    }
}
