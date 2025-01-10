@extends('layout.main')

@section('content')
<style>
    .card-custom {
        border-radius: 15px;
        border: 1px solid #ddd;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease;
    }

    .card-custom:hover {
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .list-group-item-custom {
        border-radius: 30px;
        transition: background-color 0.3s ease;
    }

    .list-group-item-custom:hover {
        background-color: #f1f1f1;
    }

    .active-chat {
        background-color: #007bff;
        color: white !important;
    }

    .chat-message {
        max-width: 70%;
        border-radius: 15px;
        padding: 12px;
        margin-bottom: 10px;
    }

    .chat-message-sender {
        background-color: #28a745;
        color: white;
    }

    .chat-message-receiver {
        background-color: #f8f9fa;
        color: #333;
    }

    #chat-window {
        height: 500px;
        overflow-y: auto;
        padding-right: 10px;
    }

    .input-group-custom {
        border-radius: 30px;
    }

    .input-group-custom input {
        border-radius: 30px;
    }

    .input-group-custom button {
        border-radius: 30px;
        background-color: #007bff;
        color: white;
        font-weight: bold;
    }

    .input-group-custom button:hover {
        background-color: #0056b3;
    }

    .error-message {
        color: red;
    }
</style>

<div class="container mt-5">
    <div class="row">
        <!-- Chat List Section -->
        <div class="col-md-4">
            <div class="card card-custom">
                <div class="card-header">
                    <strong>@lang('lang.user_chat')</strong>
                </div>
                <div class="list-group list-group-flush">
                    @foreach ($users as $user)
                        <a href="{{ route('messages.chat', ['current_chat_id' => $user->id]) }}"
                           class="list-group-item list-group-item-action d-flex align-items-center list-group-item-custom {{ $current_chat_id == $user->id ? 'active-chat' : '' }}">
                            <img src="{{ $user->profile_picture ?: asset('assets/images/default-avatar.png') }}" alt="{{ $user->name }}'s avatar"
                                 class="rounded-circle me-3" style="width: 40px; height: 40px; object-fit: cover;">
                            <span>{{ $user->name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Chat Messages Section -->
        @if ($chats)
        <div class="col-md-8">
            <div class="card card-custom">
                <div class="card-body" id="chat-window">
                    @foreach ($chats as $chat)
                        <div class="d-flex {{ $chat->sender_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }} mb-2">
                            <div class="chat-message {{ $chat->sender_id === auth()->id() ? 'chat-message-sender' : 'chat-message-receiver' }}">
                                <p class="m-0">{{ $chat->message }}</p>
                                <small class="text-muted">{{ $chat->created_at->format('d M Y H:i') }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <form method="POST" action="{{ route('messages.send', ['receiver_id'=>$current_chat_id]) }}" id="chat-form" class="mt-3">
                @csrf
                <div class="input-group input-group-custom">
                    <input type="text" name="message" id="message" class="form-control" placeholder="Type your message" required>
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
                @error('message')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </form>
        </div>
        @endif
    </div>
</div>
@endsection
