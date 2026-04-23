<?php

namespace App\Http\Controllers;

use App\Models\Bb;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $query = $user->favoriteBbs()
            ->with('category', 'user')
            ->where(function ($builder) use ($user) {
                $builder->where('bbs.status', Bb::STATUS_APPROVED);

                if ($user->isAdmin()) {
                    return;
                }

                $builder->orWhere('bbs.user_id', $user->id);
            });

        return view('favorites.index', [
            'bbs' => $query
                ->latest('favorites.created_at')
                ->get(),
        ]);
    }

    public function store(Bb $bb)
    {
        $this->ensureVisible($bb);

        Auth::user()->favoriteBbs()->syncWithoutDetaching([$bb->id]);

        return back()->with('success', 'Объявление добавлено в избранное.');
    }

    public function destroy(Bb $bb)
    {
        Auth::user()->favoriteBbs()->detach($bb->id);

        return back()->with('success', 'Объявление удалено из избранного.');
    }

    protected function ensureVisible(Bb $bb): void
    {
        $user = Auth::user();

        if ($bb->status === Bb::STATUS_APPROVED) {
            return;
        }

        if ($user && ($user->isAdmin() || $user->id === $bb->user_id)) {
            return;
        }

        abort(404);
    }
}
