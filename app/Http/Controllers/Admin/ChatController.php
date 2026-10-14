<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Semua percakapan.
     */
    public function index()
    {
        $conversations = Conversation::with([
            'customer',
            'latestMessage',
        ])
            ->latest('updated_at')
            ->get();

        return view(
            'admin.chat.index',
            compact('conversations')
        );
    }


    /**
     * Percakapan yang belum dijawab.
     */
    public function unanswered()
    {
        $conversations = Conversation::with([
            'customer',
            'latestMessage',
        ])
            ->where('status', 'open')
            ->whereHas('messages', function ($query) {

                $query->where('is_read', false)
                    ->whereHas('sender', function ($sender) {
                        $sender->where('role', 'customer');
                    });

            })
            ->latest('updated_at')
            ->get();

        return view(
            'admin.chat.index',
            compact('conversations')
        );
    }


    /**
     * Percakapan yang sudah memiliki balasan admin.
     */
    public function answered()
    {
        $conversations = Conversation::with([
            'customer',
            'latestMessage',
        ])
            ->whereHas('messages', function ($query) {

                $query->whereHas('sender', function ($sender) {
                    $sender->where('role', 'admin');
                });

            })
            ->latest('updated_at')
            ->get();

        return view(
            'admin.chat.index',
            compact('conversations')
        );
    }


    /**
     * Detail percakapan.
     */
    public function show(Conversation $conversation)
    {
        $conversation->load([
            'customer',
            'messages.sender',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Tandai pesan customer sebagai sudah dibaca
        |--------------------------------------------------------------------------
        */

        $conversation->messages()
            ->where('is_read', false)
            ->whereHas('sender', function ($query) {

                $query->where('role', 'customer');

            })
            ->update([
                'is_read' => true,
            ]);


        return view(
            'admin.chat.show',
            compact('conversation')
        );
    }


    /**
     * Admin mengirim balasan.
     */
    public function sendMessage(
        Request $request,
        Conversation $conversation
    ) {

        $data = $request->validate([
            'message' => 'required|string|max:2000',
        ]);


        if ($conversation->status === 'archived') {

            return back()->with(
                'error',
                'Percakapan sudah diarsipkan.'
            );

        }


        $conversation->messages()->create([
            'sender_id' => auth()->id(),
            'message' => $data['message'],
            'is_read' => false,
        ]);


        $conversation->update([
            'status' => 'open',
        ]);


        return back()->with(
            'success',
            'Balasan berhasil dikirim.'
        );
    }


    /**
     * Menutup percakapan.
     */
    public function close(Conversation $conversation)
    {
        $conversation->update([
            'status' => 'closed',
        ]);


        return back()->with(
            'success',
            'Percakapan berhasil ditutup.'
        );
    }


    /**
     * Mengarsipkan percakapan.
     */
    public function archive(Conversation $conversation)
    {
        $conversation->update([
            'status' => 'archived',
            'archived_at' => now(),
        ]);


        return redirect()
            ->route('admin.chat.index')
            ->with(
                'success',
                'Percakapan berhasil diarsipkan.'
            );
    }
}