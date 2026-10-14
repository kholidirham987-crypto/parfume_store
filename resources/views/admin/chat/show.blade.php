@extends('layouts.admin')

@section('title', 'Detail Chat Customer')

@section('content')

<style>

    .chat-detail-page {
        padding: 10px 5px;
    }

    /* =========================================
       HEADER
    ========================================= */

    .chat-detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;

        gap: 20px;

        margin-bottom: 22px;
    }

    .chat-detail-title {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .chat-back-button {
        display: inline-flex;
        align-items: center;
        gap: 7px;

        padding: 9px 14px;

        border: 1px solid #ded5ca;
        border-radius: 9px;

        background: #ffffff;
        color: #5a4633;

        text-decoration: none;

        font-size: 13px;
        font-weight: 600;

        transition: all .2s ease;
    }

    .chat-back-button:hover {
        background: #f7f3ed;
        color: #4b3621;
        border-color: #cfc2b4;
    }

    .chat-detail-title h2 {
        margin: 0;

        color: #3f3429;

        font-size: 23px;
        font-weight: 700;
    }

    .chat-detail-title p {
        margin: 4px 0 0;

        color: #8a7a6a;

        font-size: 13px;
    }


    /* =========================================
       CHAT CARD
    ========================================= */

    .chat-detail-card {
        overflow: hidden;

        background: #ffffff;

        border: 1px solid #e7ded4;
        border-radius: 16px;

        box-shadow: 0 5px 20px rgba(75, 54, 33, .06);
    }


    /* =========================================
       CHAT TOP BAR
    ========================================= */

    .conversation-top {
        display: flex;
        justify-content: space-between;
        align-items: center;

        padding: 16px 20px;

        border-bottom: 1px solid #eee5dc;

        background: #fffdf9;
    }

    .customer-profile {
        display: flex;
        align-items: center;

        gap: 11px;
    }

    .customer-avatar-large {
        display: flex;
        align-items: center;
        justify-content: center;

        width: 42px;
        height: 42px;

        border-radius: 50%;

        background: #198754;
        color: white;

        font-size: 16px;
        font-weight: 700;
    }

    .customer-profile-name {
        color: #3f3429;

        font-size: 14px;
        font-weight: 700;
    }

    .customer-profile-email {
        margin-top: 2px;

        color: #8a8178;

        font-size: 11px;
    }


    /* =========================================
       STATUS
    ========================================= */

    .conversation-status {
        display: inline-flex;
        align-items: center;

        gap: 6px;

        padding: 6px 10px;

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


    /* =========================================
       CHAT BODY
    ========================================= */

    .conversation-body {
        height: 500px;

        padding: 25px;

        overflow-y: auto;

        background: #faf8f3;
    }


    /* =========================================
       MESSAGE
    ========================================= */

    .message-row {
        display: flex;

        margin-bottom: 17px;
    }

    .message-row.customer {
        justify-content: flex-start;
    }

    .message-row.admin {
        justify-content: flex-end;
    }

    .message-bubble {
        max-width: 70%;

        padding: 11px 14px;

        border-radius: 14px;

        font-size: 14px;
        line-height: 1.5;
    }

    .message-bubble.customer {
        background: #ffffff;

        color: #3f3429;

        border: 1px solid #e5ddd3;

        border-bottom-left-radius: 4px;
    }

    .message-bubble.admin {
        background: #4b3621;

        color: #ffffff;

        border-bottom-right-radius: 4px;
    }

    .message-sender {
        margin-bottom: 4px;

        font-size: 10px;
        font-weight: 700;

        opacity: .65;
    }

    .message-time {
        display: block;

        margin-top: 6px;

        font-size: 10px;

        opacity: .6;
    }


    /* =========================================
       INPUT
    ========================================= */

    .reply-area {
        padding: 17px 20px;

        border-top: 1px solid #eee5dc;

        background: #ffffff;
    }

    .reply-form {
        display: flex;

        align-items: flex-end;

        gap: 10px;
    }

    .reply-form textarea {
        flex: 1;

        min-height: 48px;
        max-height: 120px;

        padding: 12px 14px;

        resize: vertical;

        border: 1px solid #dcd2c7;
        border-radius: 10px;

        outline: none;

        font-family: inherit;
        font-size: 13px;
    }

    .reply-form textarea:focus {
        border-color: #4b3621;

        box-shadow:
            0 0 0 3px rgba(75, 54, 33, .08);
    }

    .send-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        min-width: 80px;
        height: 48px;

        padding: 0 18px;

        border: none;
        border-radius: 10px;

        background: #4b3621;
        color: #ffffff;

        font-size: 13px;
        font-weight: 600;

        cursor: pointer;

        transition: .2s;
    }

    .send-button:hover {
        background: #362617;
    }


    /* =========================================
       ACTION BAR
    ========================================= */

    .conversation-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;

        padding: 13px 20px;

        border-top: 1px solid #eee5dc;

        background: #fffdf9;
    }

    .action-left {
        display: flex;
        align-items: center;
    }

    .action-right {
        display: flex;
        align-items: center;

        gap: 8px;
    }


    /* =========================================
       ACTION BUTTON
    ========================================= */

    .action-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 6px;

        min-height: 36px;

        padding: 8px 13px;

        border-radius: 8px;

        font-family: inherit;

        font-size: 12px;
        font-weight: 600;

        cursor: pointer;

        transition: all .2s ease;
    }

    .action-back {
        border: 1px solid #ded5ca;

        background: #ffffff;
        color: #5a4633;

        text-decoration: none;
    }

    .action-back:hover {
        background: #f4efe8;
    }


    .action-close {
        border: 1px solid #d9b77b;

        background: #fffaf0;
        color: #94651f;
    }

    .action-close:hover {
        background: #f8edd7;
    }


    .action-archive {
        border: 1px solid #d8aaa5;

        background: #fff8f7;
        color: #a33f36;
    }

    .action-archive:hover {
        background: #f9e5e2;
    }


    /* =========================================
       RESPONSIVE
    ========================================= */

    @media(max-width: 768px) {

        .chat-detail-page {
            padding: 0;
        }

        .chat-detail-header {
            align-items: flex-start;

            flex-direction: column;
        }

        .chat-detail-title {
            align-items: flex-start;

            flex-direction: column;
        }

        .conversation-top {
            align-items: flex-start;

            gap: 12px;

            flex-direction: column;
        }

        .conversation-body {
            height: 450px;

            padding: 18px;
        }

        .message-bubble {
            max-width: 85%;
        }

        .reply-form {
            align-items: stretch;

            flex-direction: column;
        }

        .send-button {
            width: 100%;
        }

        .conversation-actions {
            align-items: stretch;

            gap: 12px;

            flex-direction: column;
        }

        .action-left,
        .action-right {
            width: 100%;
        }

        .action-right {
            justify-content: flex-end;
        }

    }

</style>


<div class="chat-detail-page">


    {{-- =========================================
         PAGE HEADER
    ========================================== --}}

    <div class="chat-detail-header">

        <div class="chat-detail-title">

            <a
                href="{{ route('admin.chat.index') }}"
                class="chat-back-button"
            >
                ← Kembali ke Chat
            </a>

            <div>

                <h2>
                    Chat Customer
                </h2>

                <p>
                    Percakapan dengan
                    <strong>
                        {{ $conversation->customer->name }}
                    </strong>
                </p>

            </div>

        </div>

    </div>


    {{-- =========================================
         CHAT CARD
    ========================================== --}}

    <div class="chat-detail-card">


        {{-- CUSTOMER INFO --}}

        <div class="conversation-top">

            <div class="customer-profile">

                <div class="customer-avatar-large">

                    {{ strtoupper(
                        substr($conversation->customer->name, 0, 1)
                    ) }}

                </div>

                <div>

                    <div class="customer-profile-name">

                        {{ $conversation->customer->name }}

                    </div>

                    <div class="customer-profile-email">

                        {{ $conversation->customer->email }}

                    </div>

                </div>

            </div>


            {{-- STATUS --}}

            @if($conversation->status === 'open')

                <span class="conversation-status status-open">
                    ● Terbuka
                </span>

            @elseif($conversation->status === 'closed')

                <span class="conversation-status status-closed">
                    ● Ditutup
                </span>

            @else

                <span class="conversation-status status-archived">
                    ● Diarsipkan
                </span>

            @endif

        </div>


        {{-- =========================================
             MESSAGE
        ========================================== --}}

        <div class="conversation-body">

            @forelse($conversation->messages as $message)

                @php
                    $isAdmin = $message->sender->role === 'admin';
                @endphp


                <div class="message-row {{ $isAdmin ? 'admin' : 'customer' }}">

                    <div class="message-bubble {{ $isAdmin ? 'admin' : 'customer' }}">

                        <div class="message-sender">

                            {{ $isAdmin
                                ? 'Admin'
                                : $conversation->customer->name }}

                        </div>


                        {{ $message->message }}


                        <span class="message-time">

                            {{ $message->created_at->format('d M Y, H:i') }}

                        </span>

                    </div>

                </div>

            @empty

                <div style="
                    text-align:center;
                    color:#999;
                    padding-top:190px;
                ">

                    <div style="font-size:40px;">
                        💬
                    </div>

                    <h4>
                        Belum Ada Pesan
                    </h4>

                    <p>
                        Belum ada pesan dalam percakapan ini.
                    </p>

                </div>

            @endforelse

        </div>


        {{-- =========================================
             REPLY
        ========================================== --}}

        @if($conversation->status !== 'archived')

            <div class="reply-area">

                <form
                    action="{{ route('admin.chat.message', $conversation) }}"
                    method="POST"
                    class="reply-form"
                >

                    @csrf

                    <textarea
                        name="message"
                        placeholder="Tulis balasan untuk customer..."
                        required
                        maxlength="2000"
                    ></textarea>


                    <button
                        type="submit"
                        class="send-button"
                    >
                        Kirim
                    </button>

                </form>

                @error('message')

                    <small style="
                        display:block;
                        margin-top:7px;
                        color:#b52e2e;
                    ">
                        {{ $message }}
                    </small>

                @enderror

            </div>

        @endif


        {{-- =========================================
             ACTION BAR
        ========================================== --}}

        <div class="conversation-actions">


            {{-- KEMBALI --}}

            <div class="action-left">

                <a
                    href="{{ route('admin.chat.index') }}"
                    class="action-button action-back"
                >
                    ← Kembali
                </a>

            </div>


            {{-- AKSI CHAT --}}

            <div class="action-right">


                @if($conversation->status !== 'closed'
                    && $conversation->status !== 'archived')

                    <form
                        action="{{ route('admin.chat.close', $conversation) }}"
                        method="POST"
                        style="margin:0;"
                    >

                        @csrf
                        @method('PATCH')

                        <button
                            type="submit"
                            class="action-button action-close"
                            onclick="
                                return confirm(
                                    'Tutup percakapan ini?'
                                )
                            "
                        >
                            ✓ Tutup Chat
                        </button>

                    </form>

                @endif


                @if($conversation->status !== 'archived')

                    <form
                        action="{{ route('admin.chat.archive', $conversation) }}"
                        method="POST"
                        style="margin:0;"
                    >

                        @csrf
                        @method('PATCH')

                        <button
                            type="submit"
                            class="action-button action-archive"
                            onclick="
                                return confirm(
                                    'Arsipkan percakapan ini?'
                                )
                            "
                        >
                            ▣ Arsipkan
                        </button>

                    </form>

                @endif


            </div>

        </div>

    </div>

</div>

@endsection