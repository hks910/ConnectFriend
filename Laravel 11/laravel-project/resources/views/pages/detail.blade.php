@extends('layout.main')

@section('content')
<style>
    .profile-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .profile-header h1 {
        font-size: 2.5rem;
        font-weight: 600;
        color: #333;
    }

    .profile-header p {
        color: #6c757d;
        font-size: 1rem;
    }

    .profile-img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #007bff;
    }

    .list-group-item {
        border-radius: 10px;
        margin-bottom: 10px;
        background-color: #f8f9fa;
        transition: background-color 0.3s ease;
    }

    .list-group-item:hover {
        background-color: #e9ecef;
    }

    .card-custom {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: box-shadow 0.3s ease;
    }

    .card-custom:hover {
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
    }

    .card-header-custom {
        background-color: #007bff;
        color: white;
        font-weight: bold;
        padding: 15px;
    }

    .card-body-custom {
        padding: 20px;
    }

    .card-body-custom a {
        color: #007bff;
        font-weight: 500;
        text-decoration: none;
    }

    .card-body-custom a:hover {
        text-decoration: underline;
    }
</style>

<div class="container mt-4">
    <!-- Profile Header Section -->
    <div class="profile-header">
        <h1>{{ $user->name }}'s Profile</h1>
        <p class="text-muted">{{ $user->email }}</p>
        <img src="{{ $user->profile_picture ?: asset('assets/images/default.jpg') }}" alt="Profile Picture" class="profile-img">
    </div>

    <!-- Profile Details Section -->
    <div class="row">
        <div class="col-md-6">
            <div class="card card-custom">
                <div class="card-header card-header-custom">
                    <h5>@lang('lang.profile_detail')</h5>
                </div>
                <div class="card-body card-body-custom">
                    <ul class="list-group">
                        <li class="list-group-item"><strong>@lang('lang.gender'): </strong>{{ $user->gender }}</li>
                        <li class="list-group-item"><strong>@lang('lang.fields_of_work'): </strong>{{ implode(', ', json_decode($user->fields_of_work, true)) }}</li>
                        <li class="list-group-item">
                            <strong>LinkedIn: </strong>
                            <a href="{{ $user->linkedin_username }}" target="_blank" rel="noopener noreferrer">{{ $user->linkedin_username }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const toggle = document.getElementById('profileVisibilityToggle');
    const form = document.getElementById('visibilityForm');

    toggle.addEventListener('change', () => {
        form.submit();
    });
</script>
@endsection
