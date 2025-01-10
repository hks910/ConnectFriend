@extends('layout.main')

@section('content')
<style>
    .tab-content {
        padding: 20px;
        border-radius: 10px;
        background-color: #f9f9f9;
    }

    .nav-pills .nav-link {
        border-radius: 30px;
        font-weight: 500;
        padding: 10px 20px;
    }

    .nav-pills .nav-link.active {
        background-color: #007bff;
        color: white;
    }

    .card-custom {
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease;
    }

    .card-custom:hover {
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .card-body-custom {
        display: flex;
        align-items: center;
    }

    .profile-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 50%;
    }

    .card-text-muted {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .button-group {
        display: flex;
        gap: 10px;
    }

    .btn-custom {
        flex: 1;
        padding: 8px 0;
        font-size: 0.9rem;
    }

    .btn-custom.accept {
        background-color: #28a745;
        color: white;
    }

    .btn-custom.reject {
        background-color: #dc3545;
        color: white;
    }

    .card-header-custom {
        background-color: #007bff;
        color: white;
        font-weight: 600;
        text-align: center;
        padding: 12px;
        border-radius: 12px 12px 0 0;
    }

    .card-body-custom h5 {
        font-size: 1.2rem;
        font-weight: 500;
    }

    .chat-button {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 5px;
    }
</style>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-9">
            <h3 class="mb-4">@lang('lang.friend_request')</h3>
            <ul class="nav nav-pills mb-3" id="friendTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="pending-tab" data-bs-toggle="pill" href="#pending" role="tab" aria-controls="pending" aria-selected="true">@lang('lang.pending_request')</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="accepted-tab" data-bs-toggle="pill" href="#accepted" role="tab" aria-controls="accepted" aria-selected="false">@lang('lang.accepted_friend')</a>
                </li>
            </ul>
            <div class="tab-content" id="friendTabContent">
                <!-- Pending Requests Tab -->
                <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                    <div class="row">
                        @foreach($pendingRequests as $user)
                            <div class="col-md-4">
                                <div class="card mb-4 card-custom">
                                    <div class="card-body card-body-custom">
                                        <img src="{{ asset('assets/images/default-avatar.png') }}" class="profile-img me-3" alt="User Avatar">
                                        <div class="flex-grow-1">
                                            <a href="{{ route('profile.detail', ['user_id'=>$user->id]) }}" class="text-decoration-none text-dark">{{ $user->name }}</a>
                                            <p class="card-text-muted mb-2">{{ Str::limit(implode(', ', json_decode($user->fields_of_work, true)), 20, '...') }}</p>
                                            <div class="button-group">
                                                <form method="POST" action="{{ route('friends.requests.accept', ['sender_id'=>$user->id]) }}" class="w-50">
                                                    @csrf
                                                    <button type="submit" class="btn btn-custom accept">@lang('lang.accept')</button>
                                                </form>
                                                <form method="POST" action="{{ route('friends.requests.reject', ['sender_id'=>$user->id]) }}" class="w-50">
                                                    @csrf
                                                    <button type="submit" class="btn btn-custom reject">@lang('lang.reject')</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Accepted Friends Tab -->
                <div class="tab-pane fade" id="accepted" role="tabpanel" aria-labelledby="accepted-tab">
                    <div class="row">
                        @foreach($acceptedFriends as $friend)
                            <div class="col-md-4">
                                <div class="card mb-4 card-custom">
                                    <div class="card-body card-body-custom">
                                        <img src="{{ $friend->profile_picture ?: asset('assets/images/default-avatar.png') }}" class="profile-img me-3" alt="User Avatar">
                                        <div class="flex-grow-1">
                                            <h5 class="card-title mb-1">{{ $friend->name }}</h5>
                                            <p class="card-text-muted mb-1">{{ Str::limit(implode(', ', json_decode($friend->fields_of_work, true)), 24, '...') }}</p>
                                            <a href="{{ route('messages.chat', ['current_chat_id' => $friend->id]) }}" class="chat-button"><i class="bi bi-chat-dots"></i> @lang('lang.chat')</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
