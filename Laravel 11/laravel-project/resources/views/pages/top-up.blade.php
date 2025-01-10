@extends('layout.main')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center">Top Up Coins</h1>

        @if (session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        <div class="text-center">
            <p>Your current balance: <strong>{{ Auth::user()->coin }} coins</strong></p>
            <form method="POST" action="{{ route('wallet.topup') }}">
                @csrf
                <button type="submit" class="btn btn-primary">Top Up 100 Coins</button>
            </form>
        </div>
    </div>
@endsection