@extends('layouts.app')

@section('title', 'Products - Mini Cart')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">
            <i class="fas fa-box-open"></i> Our Products
        </h2>
        
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                                <i class="fas fa-tag"></i> {{ $product['name'] }}
                            </h5>
                            <p class="card-text text-muted">
                                Premium quality {{ strtolower($product['name']) }} at the best price.
                            </p>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h4 text-primary">
                                        ${{ number_format($product['price'], 2) }}
                                    </span>
                                    <form action="{{ route('cart.add', $product['id']) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-cart-plus"></i> Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection