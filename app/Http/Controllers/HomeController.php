<?php

namespace App\Http\Controllers;

use App\Models\Bb;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home', [
            'bbs' => Auth::user()->bbs()->with('category')->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('bb-create', [
            'categories' => Category::listingTypes()->get(),
            'brands' => Brand::names(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'brand' => ['required', Rule::exists('brands', 'name')],
            'content' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $bb = Auth::user()->bbs()->create([
            'title' => $validated['title'],
            'brand' => $validated['brand'],
            'content' => $validated['content'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'status' => Bb::STATUS_PENDING,
        ]);

        if ($request->hasFile('image')) {
            $bb->update([
                'image' => $this->saveUploadedImage($request->file('image'), $bb->id),
            ]);
        }

        return redirect()->route('home')->with('success', 'Объявление отправлено на рассмотрение.');
    }

    public function edit(Bb $bb)
    {
        if ($bb->user_id !== Auth::id()) {
            abort(403, 'У вас нет прав для редактирования этого объявления');
        }

        return view('bb-edit', [
            'bb' => $bb,
            'categories' => Category::listingTypes()->get(),
            'brands' => Brand::names(),
        ]);
    }

    public function update(Request $request, Bb $bb)
    {
        if ($bb->user_id !== Auth::id()) {
            abort(403, 'У вас нет прав для редактирования этого объявления');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'brand' => ['required', Rule::exists('brands', 'name')],
            'content' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'title' => $validated['title'],
            'brand' => $validated['brand'],
            'content' => $validated['content'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'status' => Bb::STATUS_PENDING,
        ];

        if ($request->hasFile('image')) {
            $this->deleteImageFiles($bb->image);
            $data['image'] = $this->saveUploadedImage($request->file('image'), $bb->id);
        }

        $bb->fill($data);
        $bb->save();

        return redirect()->route('home')->with('success', 'Изменения сохранены и отправлены на повторное рассмотрение.');
    }

    public function delete(Bb $bb)
    {
        if ($bb->user_id !== Auth::id()) {
            abort(403, 'У вас нет прав для удаления этого объявления');
        }

        return view('bb-delete', ['bb' => $bb]);
    }

    public function destroy(Bb $bb)
    {
        if ($bb->user_id !== Auth::id()) {
            abort(403, 'У вас нет прав для удаления этого объявления');
        }

        $this->deleteImageFiles($bb->image);
        $bb->delete();

        return redirect()->route('home');
    }

    protected function saveUploadedImage($image, int $bbId): string
    {
        $extension = strtolower($image->getClientOriginalExtension());
        $imageName = 'car_' . $bbId . '.' . $extension;
        $directory = public_path('uploads/cars');

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $image->move($directory, $imageName);

        return 'uploads/cars/' . $imageName;
    }

    protected function deleteImageFiles(?string $imagePath): void
    {
        if (!$imagePath) {
            return;
        }

        $paths = [
            public_path($imagePath),
            public_path('storage/cars/' . basename($imagePath)),
            storage_path('app/public/cars/' . basename($imagePath)),
        ];

        foreach ($paths as $path) {
            if (File::exists($path)) {
                File::delete($path);
            }
        }
    }
}
