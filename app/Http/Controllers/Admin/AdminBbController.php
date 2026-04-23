<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bb;
use App\Models\Brand;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class AdminBbController extends Controller
{
    public function index()
    {
        return view('admin.bbs.index', [
            'bbs' => Bb::with('user', 'category')->latest()->paginate(12),
        ]);
    }

    public function create()
    {
        return view('admin.bbs.create', [
            'bb' => new Bb(),
            'users' => User::orderBy('name')->get(),
            'categories' => Category::listingTypes()->get(),
            'brands' => Brand::names(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateBb($request);

        $bb = Bb::create([
            'title' => $validated['title'],
            'brand' => $validated['brand'],
            'content' => $validated['content'],
            'price' => $validated['price'],
            'user_id' => $validated['user_id'],
            'category_id' => $validated['category_id'],
            'status' => $validated['status'] ?? Bb::STATUS_APPROVED,
        ]);

        if ($request->hasFile('image')) {
            $bb->update([
                'image' => $this->saveUploadedImage($request->file('image'), $bb->id),
            ]);
        }

        return redirect()->route('admin.bbs.index')->with('success', 'Автомобиль добавлен.');
    }

    public function edit(Bb $bb)
    {
        return view('admin.bbs.edit', [
            'bb' => $bb,
            'users' => User::orderBy('name')->get(),
            'categories' => Category::listingTypes()->get(),
            'brands' => Brand::names(),
        ]);
    }

    public function update(Request $request, Bb $bb)
    {
        $validated = $this->validateBb($request);

        $data = [
            'title' => $validated['title'],
            'brand' => $validated['brand'],
            'content' => $validated['content'],
            'price' => $validated['price'],
            'user_id' => $validated['user_id'],
            'category_id' => $validated['category_id'],
            'status' => $validated['status'] ?? $bb->status,
        ];

        if ($request->hasFile('image')) {
            $this->deleteImageFiles($bb->image);
            $data['image'] = $this->saveUploadedImage($request->file('image'), $bb->id);
        }

        $bb->update($data);

        return redirect()->route('admin.bbs.index')->with('success', 'Автомобиль обновлён.');
    }

    public function approve(Bb $bb)
    {
        $bb->update(['status' => Bb::STATUS_APPROVED]);

        return redirect()->route('admin.bbs.index')->with('success', 'Объявление одобрено.');
    }

    public function reject(Bb $bb)
    {
        $bb->update(['status' => Bb::STATUS_REJECTED]);

        return redirect()->route('admin.bbs.index')->with('success', 'Объявление отклонено.');
    }

    public function destroy(Bb $bb)
    {
        $this->deleteImageFiles($bb->image);
        $bb->delete();

        return redirect()->route('admin.bbs.index')->with('success', 'Автомобиль удалён.');
    }

    protected function validateBb(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'brand' => ['required', Rule::exists('brands', 'name')],
            'content' => 'required|string',
            'price' => 'required|numeric|min:0',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'status' => 'nullable|in:pending,approved,rejected',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
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
