@extends('layouts.customer')

@section('title', 'Chat dengan Admin')

@section('content')

<style>
    .chat-wrapper {
        max-width: 900px;
        margin: 40px auto;
    }

    .chat-card {
        background: #fff;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0,0,0,.08);
        border: 1px solid #eee8df;
    }

    .chat-header {
        padding: 20px 24px;
        background: #fffdf8;
        border-bottom: 1px solid #eee8df;
    }

    .chat-header h4 {
        margin: 0;
        font-weight: 700;
    }

    .chat-status {
        font-size: 13px;
        color: #198754;
        margin-top: 4px;
    }

    .chat-body {
        padding: 25px;
        height: 500px;
        overflow-y: auto;
        background: #faf8f3;
    }

    .message-row {
        display: flex;
        margin-bottom: 16px;
    }

    .message-row.customer {
        justify-content: flex-end;
    }

    .message {
        max-width: 70%;
        padding: 11px 15px;
        border-radius: 15px;
        font-size: 14px;
        line-height: 1.5;
    }

    .message.admin {
        background: #fff;
        border: 1px solid #e8e2d8;
    }

    .message.customer {
        background: #198754;
        color: white;
    }

    .message-time {
        display: block;
        margin-top: 5px;
        font-size: 10px;
        opacity: .7;
    }

    .chat-footer {
        padding: 18px;
        background: #fff;
        border-top: 1px solid #eee8df;
    }

    .chat-input {
        display: flex;
        gap: 10px;
    }

    .chat-input textarea {
        flex: 1;
        resize: none;
        border: 1px solid #ddd6ca;
        border-radius: 12px;
        padding: 12px;
    }

    .chat-input textarea:focus {
        outline: none;
        border-color: #198754;
        box-shadow: 0 0 0 2px rgba(25,135,84,.1);
    }

    .chat-input button {
        border: none;
        border-radius: 12px;
        padding: 0 22px;
        background: #198754;
        color: white;
        font-weight: 600;
    }

    .chat-input button:hover {
        background: #146c43;
    }

    .chat-empty {
        text-align: center;
        color: #888;
        padding-top: 180px;
    }
</style>

<div class="container">

    <div class="chat-wrapper">

        <div class="chat-card">

            {{-- HEADER --}}
            <div class="chat-header">

                <h4>
                    💬 Chat dengan Admin
                </h4>

                <div class="chat-status">
                    ● Layanan Customer
                </div>

            </div>


            {{-- PESAN --}}
            <div class="chat-body">

                @forelse($conversation->messages as $message)

                    @php
                        $isCustomer = $message->sender_id === auth()->id();
                    @endphp

                    <div class="message-row {{ $isCustomer ? 'customer' : '' }}">

                        <div class="message {{ $isCustomer ? 'customer' : 'admin' }}">

                            {{ $message->message }}

                            <span class="message-time">
                                {{ $message->created_at->format('d M Y, H:i') }}
                            </span>

                        </div>

                    </div>

                @empty

                    <div class="chat-empty">

                        <h5>Belum ada pesan</h5>

                        <p>
                            Silakan kirim pesan kepada admin.
                        </p>

                    </div>

                @endforelse

            </div>


            {{-- INPUT --}}
            <div class="chat-footer">

                <form action="{{ route('customer.chat.message') }}"
                      method="POST">

                    @csrf

                    <div class="chat-input">

                        <textarea
                            name="message"
                            rows="2"
                            placeholder="Tulis pesan kepada admin..."
                            required></textarea>

                        <button type="submit">
                            Kirim
                        </button>

                    </div>

                    @error('message')

                        <small class="text-danger">
                            {{ $message }}
                        </small>

                    @enderror

                </form>

            </div>

        </div>

    </div>

</div>

@endsection