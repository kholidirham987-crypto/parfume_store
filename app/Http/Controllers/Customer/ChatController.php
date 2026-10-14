<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $conversation = $user->conversations()
            ->where('status', '!=', 'archived')
            ->with('messages.sender')
            ->latest()
            ->first();

        if (!$conversation) {
            $conversation = $user->conversations()->create([
                'status' => 'open',
            ]);
        }

        $conversation->load('messages.sender');

        return view('customer.chat.index', compact('conversation'));
    }

    public function sendMessage(Request $request)
    {
        $data = $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $user = auth()->user();

        $conversation = $user->conversations()
            ->where('status', '!=', 'archived')
            ->latest()
            ->first();

        if (!$conversation) {
            $conversation = $user->conversations()->create([
                'status' => 'open',
            ]);
        }

        $conversation->messages()->create([
            'sender_id' => $user->id,
            'message' => $data['message'],
            'is_read' => false,
        ]);

        return redirect()
            ->route('customer.chat')
            ->with('success', 'Pesan berhasil dikirim.');
    }
}
