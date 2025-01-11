@extends('layout.main')

@section('content')
<style>
    .card-custom {
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-custom:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .card-img-top {
        border-radius: 50%;
        object-fit: cover;
    }

    .card-body {
        padding: 1.25rem;
        background-color: #f9f9f9;
        border-radius: 0 0 15px 15px;
    }

    .card-body h5 {
        font-size: 1.2rem;
        color: #333;
    }

    .card-body p {
        font-size: 0.95rem;
        color: #666;
    }

    .btn-see-more {
        background-color: #007bff;
        color: white;
        padding: 12px 24px;
        font-size: 1rem;
        border-radius: 30px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .btn-see-more:hover {
        background-color: #0056b3;
    }

    .user-gallery {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .user-gallery .card-custom {
        width: 30%;
        margin-bottom: 30px;
    }

    @media (max-width: 768px) {
        .user-gallery .card-custom {
            width: 45%;
        }
    }

    @media (max-width: 480px) {
        .user-gallery .card-custom {
            width: 100%;
        }
    }
</style>
<div class="container mt-5">
    <div class="text-center mb-5">
        <img src="{{ asset('assets/images/logo.png') }}" class="img-fluid mb-3" alt="Logo" style="max-width: 200px;">
        <h1 class="font-weight-bold text-primary">@lang('lang.welcome_to_connect_friend')</h1>
        <p class="text-muted">@lang('lang.find_friends_based_on_your_interests_and_profession')</p>
    </div>
    <div class="user-gallery" id="userGallery">
        @foreach($users as $user)
            <div class="card-custom">
                <a href="{{ route('profile.detail', ['user_id' => $user->id]) }}" class="text-decoration-none">
                    <div class="card text-center">
                        <div class="card-img-top d-flex justify-content-center mt-4">
                            <img src="{{ $user->profile_picture ?: asset('assets/images/default.jpg') }}" alt="User Photo" style="width: 150px; height: 150px;">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $user->name }}</h5>
                            <p class="card-text">@lang('lang.profession'): {{ Str::limit(implode(', ', json_decode($user->fields_of_work, true)), 30, '...') }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    <div class="text-center mt-5">
        <a href="{{ route('friends.page') }}" class="btn-see-more">@lang('lang.see_more')</a>
    </div>
</div>
@endsection
