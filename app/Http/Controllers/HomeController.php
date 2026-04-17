<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Bb;
class HomeController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home',['bbs' => Auth::user()->bbs()->latest()->get()]);
    }

    public function create() {
        return view('bb-create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $data = [
            'title' => $validated['title'],
            'content' => $validated['content'],
            'price' => $validated['price']
        ];
        
        // Создаем объявление сначала, чтобы получить ID
        $bb = Auth::user()->bbs()->create($data);
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Получаем расширение файла
            $extension = $image->getClientOriginalExtension();
            // Создаем имя файла с ID объявления: car_{ID}.{расширение}
            $imageName = 'car_' . $bb->id . '.' . $extension;
            
            // Сохраняем изображение с новым именем
            $image->storeAs('public/cars', $imageName);
            $data['image'] = 'storage/cars/' . $imageName;
            
            // Обновляем запись с путем к изображению
            $bb->update(['image' => $data['image']]);
        }
        
        return redirect()->route('home')->with('success', 'Объявление успешно добавлено!');
    }

    public function edit(Bb $bb) {
        // Проверяем, что пользователь является владельцем объявления
        if ($bb->user_id !== Auth::id()) {
            abort(403, 'У вас нет прав для редактирования этого объявления');
        }
        return view('bb-edit', ['bb' => $bb]);
    }

    public function update(Request $request, Bb $bb) {
        // Проверяем, что пользователь является владельцем объявления
        if ($bb->user_id !== Auth::id()) {
            abort(403, 'У вас нет прав для редактирования этого объявления');
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $data = [
            'title' => $validated['title'],
            'content' => $validated['content'],
            'price' => $validated['price']
        ];
        
        if ($request->hasFile('image')) {
            // Удаляем старое изображение если есть
            if ($bb->image) {
                $oldImagePath = storage_path('app/public/cars/' . basename($bb->image));
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                // Также проверяем путь через public
                $oldPublicPath = public_path($bb->image);
                if (file_exists($oldPublicPath)) {
                    unlink($oldPublicPath);
            }
            }
            
            $image = $request->file('image');
            // Получаем расширение файла
            $extension = $image->getClientOriginalExtension();
            // Создаем имя файла с ID объявления: car_{ID}.{расширение}
            $imageName = 'car_' . $bb->id . '.' . $extension;
            
            // Сохраняем изображение с новым именем
            $image->storeAs('public/cars', $imageName);
            $data['image'] = 'storage/cars/' . $imageName;
        }
        
        $bb->fill($data);
        $bb->save();
        return redirect()->route('home')->with('success', 'Объявление успешно обновлено!');
    }

    public function delete(Bb $bb) {
        // Проверяем, что пользователь является владельцем объявления
        if ($bb->user_id !== Auth::id()) {
            abort(403, 'У вас нет прав для удаления этого объявления');
        }
        return view('bb-delete', ['bb' => $bb]);
    }

    public function destroy(Bb $bb) {
        // Проверяем, что пользователь является владельцем объявления
        if ($bb->user_id !== Auth::id()) {
            abort(403, 'У вас нет прав для удаления этого объявления');
        }
        
        // Удаляем изображение если оно есть
        if ($bb->image) {
            $imagePath = storage_path('app/public/cars/' . basename($bb->image));
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            // Также проверяем путь через public
            $publicPath = public_path($bb->image);
            if (file_exists($publicPath)) {
                unlink($publicPath);
            }
        }
        
        $bb->delete();
        return redirect()->route('home');
    }
    
}