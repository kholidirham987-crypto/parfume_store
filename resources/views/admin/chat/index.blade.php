@extends('layouts.admin')

@section('title', 'Chat Customer')

@section('content')

<style>
    .chat-page {
        padding: 25px;
    }

    .chat-header {
        margin-bottom: 25px;
    }

    .chat-header h3 {
        margin: 0;
        font-weight: 700;
        color: #5a4633;
    }

    .chat-header p {
        margin-top: 5px;
        color: #8a7a6a;
    }

    .chat-filter {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .chat-filter a {
        text-decoration: none;
        padding: 9px 16px;
        border-radius: 8px;
        background: #fffaf3;
        color: #5a4633;
        border: 1px solid #eadfce;
        font-size: 14px;
        font-weight: 600;
    }

    .chat-filter a:hover,
    .chat-filter a.active {
        background: #198754;
        color: white;
        border-color: #198754;
    }

    .chat-list {
        background: white;
        border-radius: 15px;
        border: 1px solid #eadfce;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,.05);
    }

    .chat-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 18px 20px;
        border-bottom: 1px solid #eee8df;
        text-decoration: none;
        color: inherit;
        transition: .2s;
    }

    .chat-item:last-child {
        border-bottom: none;
    }

    .chat-item:hover {
        background: #fffaf3;
    }

    .customer-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #198754;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
        flex-shrink: 0;
    }

    .chat-info {
        flex: 1;
        min-width: 0;
    }

    .customer-name {
        font-weight: 700;
        color: #3f3429;
        margin-bottom: 4px;
    }

    .latest-message {
        color: #8a8178;
        font-size: 13px;

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;

        max-width: 600px;
    }

    .chat-meta {
        text-align: right;
        min-width: 110px;
    }

    .chat-time {
        font-size: 11px;
        color: #999;
        margin-bottom: 6px;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .status-open {
        background: #e8f7ef;
        color: #198754;
    }

    .status-closed {
        background: #f1f1f1;
        color: #777;
    }

    .status-archived {
        background: #f7eee4;
        color: #8a6341;
    }

    .empty-chat {
        padding: 70px 20px;
        text-align: center;
        color: #888;
    }

    .empty-chat-icon {
        font-size: 45px;
        margin-bottom: 10px;
    }

    @media(max-width: 768px) {

        .chat-page {
            padding: 15px;
        }

        .chat-item {
            padding: 15px;
        }

        .chat-meta {
            min-width: auto;
        }

        .latest-message {
            max-width: 180px;
        }
    }
</style>

<div class="chat-page">

    <div class="chat-header">
        <h3>💬 Chat Customer</h3>
        <p>Kelola percakapan antara customer dan admin.</p>
    </div>


    {{-- FILTER --}}

    <div class="chat-filter">

        <a
            href="{{ route('admin.chat.index') }}"
            class="{{ request()->routeIs('admin.chat.index') ? 'active' : '' }}"
        >
            Semua
        </a>

        <a
            href="{{ route('admin.chat.unanswered') }}"
            class="{{ request()->routeIs('admin.chat.unanswered') ? 'active' : '' }}"
        >
            Belum Dijawab
        </a>

        <a
            href="{{ route('admin.chat.answered') }}"
            class="{{ request()->routeIs('admin.chat.answered') ? 'active' : '' }}"
        >
            Sudah Dijawab
        </a>

    </div>


    {{-- SUCCESS --}}

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    {{-- CHAT LIST --}}

    <div class="chat-list">

        @forelse($conversations as $conversation)

            <a
                href="{{ route('admin.chat.show', $conversation) }}"
                class="chat-item"
            >

                <div class="customer-avatar">
                    {{ strtoupper(substr($conversation->customer->name, 0, 1)) }}
                </div>


                <div class="chat-info">

                    <div class="customer-name">
                        {{ $conversation->customer->name }}
                    </div>

                    <div class="latest-message">

                        @if($conversation->latestMessage)
                            {{ $conversation->latestMessage->message }}
                        @else
                            Belum ada pesan
                        @endif

                    </div>

                </div>


                <div class="chat-meta">

                    @if($conversation->latestMessage)

                        <div class="chat-time">
                            {{ $conversation->latestMessage->created_at->format('d M Y H:i') }}
                        </div>

                    @endif


                    @if($conversation->status === 'open')

                        <span class="status-badge status-open">
                            Terbuka
                        </span>

                    @elseif($conversation->status === 'closed')

                        <span class="status-badge status-closed">
                            Ditutup
                        </span>

                    @else

                        <span class="status-badge status-archived">
                            Arsip
                        </span>

                    @endif

                </div>

            </a>

        @empty

            <div class="empty-chat">

                <div class="empty-chat-icon">
                    💬
                </div>

                <h5>Belum ada percakapan</h5>

                <p>
                    Percakapan dari customer akan muncul di sini.
                </p>

            </div>

        @endforelse

    </div>

</div>

@endsection