@extends('layout.main')

@section('content')
<style>
    /* Sidebar Styling */
    .sidebar {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .form-label {
        font-weight: 600;
        font-size: 1rem;
    }

    .form-select, .form-control {
        border-radius: 8px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        padding: 10px 0;
        font-size: 1rem;
        border-radius: 8px;
    }

    /* User Cards Styling */
    .user-card {
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease;
        background-color: #ffffff;
    }

    .user-card:hover {
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .user-card-body {
        display: flex;
        align-items: center;
        padding: 20px;
    }

    .user-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 50%;
        margin-right: 15px;
    }

    .user-name {
        font-size: 1.2rem;
        font-weight: 600;
    }

    .user-job {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .user-card-footer {
        display: flex;
        justify-content: space-between;
        padding-top: 15px;
    }

    .no-data-alert {
        font-size: 1.2rem;
        background-color: #e9ecef;
        border-radius: 12px;
        padding: 40px;
        text-align: center;
    }

    .no-data-alert i {
        font-size: 40px;
    }

    .no-data-alert h4 {
        margin-top: 20px;
        font-size: 1.2rem;
    }
</style>

<div class="container mt-4">
    <div class="row">
        <!-- Filter Sidebar -->
        <div class="col-md-3">
            <div class="sidebar">
                <h5>@lang('lang.filter')</h5>
                <form method="GET" action="{{ route('friends.page') }}">
                    <div class="mb-3">
                        <label for="genderFilter" class="form-label">@lang('lang.gender')</label>
                        <select name="gender" id="genderFilter" class="form-select">
                            <option value="">@lang('lang.all')</option>
                            <option value="Male" {{ $gender_filter == 'Male' ? 'selected' : ''}}>@lang('lang.male')</option>
                            <option value="Female" {{ $gender_filter == 'Female' ? 'selected' : ''}}>@lang('lang.female')</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fieldWorkFilter" class="form-label">@lang('lang.fields_of_work')</label>
                        <input type="text" name="fields_of_work" id="fieldWorkFilter" class="form-control" placeholder="@lang('lang.search')" value="{{ $fields_of_work_filter }}">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">@lang('lang.apply_filter')</button>
                </form>
            </div>
        </div>

        <!-- User List -->
        <div class="col-md-9">
            <h3>@lang('lang.friend')</h3>
            <div class="row">
                @forelse ($users as $user)
                    <div class="col-md-4">
                        <div class="card user-card mb-4">
                            <form method="POST" action="{{ route('friends.add', ['receiver_id'=>$user->id]) }}" class="user-card-body">
                                @csrf
                                <img src="{{ $user->profile_picture ?: asset('assets/images/default-avatar.png') }}" class="user-img" alt="User Avatar">
                                <div>
                                    <h5 class="user-name"><a href="{{ route('profile.detail', ['user_id'=>$user->id]) }}" class="text-decoration-none text-dark">{{ $user->name }}</a></h5>
                                    <p class="user-job">{{ Str::limit(implode(', ', json_decode($user->fields_of_work, true)), 20, '...') }}</p>
                                </div>
                            </form>
                            <div class="user-card-footer">
                                <form method="POST" action="{{ route('addFriend', ['friends.add'=>$user->id]) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">👍 @lang('lang.add_friend')</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert no-data-alert">
                            <i class="bi bi-person-x-fill"></i>
                            <h4>@lang('lang.no_friends_available')</h4>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
