<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bb;
use App\Models\Brand;
use App\Models\Category;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'usersCount' => User::count(),
            'adminsCount' => User::where('is_admin', true)->count(),
            'carsCount' => Bb::count(),
            'categoriesCount' => Category::count(),
            'brandsCount' => Brand::count(),
            'latestUsers' => User::latest()->take(5)->get(),
            'latestCars' => Bb::with('user', 'category')->latest()->take(6)->get(),
        ]);
    }
}
