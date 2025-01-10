@extends('layout.main')

@section('content')
<style>
    .card-custom {
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid #e0e0e0;
    }

    .card-custom:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .card-img-top {
        width: 100%;
        height: 200px;
        object-fit: contain;
        border-radius: 15px 15px 0 0;
    }

    .card-body {
        background-color: #f9f9f9;
        padding: 1.5rem;
        text-align: center;
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: bold;
        color: #333;
    }

    .card-text {
        font-size: 1rem;
        color: #666;
        margin-bottom: 1rem;
    }

    .price {
        font-size: 1.1rem;
        font-weight: bold;
        color: #007bff;
    }

    .btn-buy {
        background-color: #28a745;
        color: white;
        font-weight: bold;
        padding: 8px 20px;
        border-radius: 30px;
        transition: background-color 0.3s ease;
    }

    .btn-buy:hover {
        background-color: #218838;
    }

    .btn-disabled {
        background-color: #6c757d;
        color: white;
        font-weight: bold;
        padding: 8px 20px;
        border-radius: 30px;
        cursor: not-allowed;
    }

    .pagination {
        justify-content: center;
    }
</style>

<div class="container mt-5">
    <div class="text-center mb-5">
        <h1 class="font-weight-bold text-primary">@lang('lang.avatar_shop')</h1>
        <p class="text-muted">@lang('lang.avatar_shop_tag')</p>
    </div>
    <div class="row">
        @foreach($avatars as $avatar)
        <div class="col-md-4 mb-4">
            <div class="card-custom">
                <img src="{{ asset($avatar->path) }}" class="card-img-top" alt="{{ $avatar->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $avatar->name }}</h5>
                    <p class="card-text">{{ $avatar->description }}</p>
                    <p class="price">{{ $avatar->price }} Coins</p>
                    @if (Auth::user()->coin >= $avatar->price)
                        <form method="POST" action="{{ route('market.avatar.purchase', ['avatar_id'=>$avatar->id]) }}">
                            @csrf
                            <button type="submit" class="btn-buy">@lang('lang.buy_now')</button>
                        </form>
                    @else
                        <button class="btn-disabled" disabled>@lang('lang.insufficient_coins')</button>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $avatars->links() }}
    </div>
</div>
@endsection
