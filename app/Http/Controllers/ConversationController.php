<?php

namespace App\Http\Controllers;

use App\Models\Bb;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $conversations = Conversation::with(['bb.category', 'buyer', 'seller', 'latestMessage.user'])
            ->where(function ($query) use ($user) {
                $query->where('buyer_id', $user->id)
                    ->orWhere('seller_id', $user->id);
            })
            ->latest('updated_at')
            ->get();

        return view('messages.index', [
            'conversations' => $conversations,
        ]);
    }

    public function store(Request $request, Bb $bb)
    {
        $user = Auth::user();
        $this->ensureCanContact($bb, $user->id);

        $validated = $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        $conversation = Conversation::firstOrCreate([
            'bb_id' => $bb->id,
            'buyer_id' => $user->id,
            'seller_id' => $bb->user_id,
        ]);

        $conversation->messages()->create([
            'user_id' => $user->id,
            'body' => $validated['body'],
        ]);

        return redirect()
            ->route('messages.show', $conversation)
            ->with('success', 'Сообщение отправлено продавцу.');
    }

    public function show(Conversation $conversation)
    {
        $this->ensureParticipant($conversation);

        $conversation->load([
            'bb.category',
            'buyer',
            'seller',
            'messages.user',
        ]);

        return view('messages.show', [
            'conversation' => $conversation,
        ]);
    }

    public function send(Request $request, Conversation $conversation)
    {
        $user = Auth::user();
        $this->ensureParticipant($conversation);

        $validated = $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        $conversation->messages()->create([
            'user_id' => $user->id,
            'body' => $validated['body'],
        ]);

        return redirect()
            ->route('messages.show', $conversation)
            ->with('success', 'Сообщение отправлено.');
    }

    public function destroy(Conversation $conversation)
    {
        $this->ensureParticipant($conversation);

        $conversation->delete();

        return redirect()
            ->route('messages.index')
            ->with('success', 'Диалог удалён.');
    }

    protected function ensureParticipant(Conversation $conversation): void
    {
        $userId = Auth::id();

        if ($conversation->buyer_id !== $userId && $conversation->seller_id !== $userId) {
            abort(403);
        }
    }

    protected function ensureCanContact(Bb $bb, int $userId): void
    {
        if ($bb->user_id === $userId) {
            abort(403, 'Нельзя писать самому себе.');
        }

        if ($bb->status !== Bb::STATUS_APPROVED) {
            abort(404);
        }
    }
}
