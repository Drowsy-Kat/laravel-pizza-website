@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header">{{ __('Navigation') }}</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Menu') }}</h5>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-action">
                                    <a href="{{ route('customer.menu') }}" class="text-decoration-none">{{ __('View Pizzas') }}</a>
                                </li>
                            </ul>
                            <h5 class="card-title mt-3">{{ __('Account') }}</h5>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-action">
                                    <a href="{{ route('customer.cart') }}" class="text-decoration-none">{{ __('Cart') }}</a>
                                </li>
                                <li class="list-group-item list-group-item-action">
                                    <a href="{{ route('customer.history') }}" class="text-decoration-none">{{ __('History') }}</a>
                                </li>
                            </ul>
                        </div>



                        @if(Session::has('success_message'))
                            <div class="card m-5">
                                <div class="card-body">
                                    <div class="alert alert-success">
                                        {{ Session::get('success_message') }}
                                    </div>    
                                </div>
                            </div>

                        @endif
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Order') }}</div>
                        <div class="card-body">
                            @if (session('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                            @endif
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">size</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Image</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($orderItems)>0)
                                    
                                    @foreach($orderItems as $orderItem)
                                    <tr>
                                        <th scope="row">{{ $orderItem->pizza->pizza_name}}</th>
                                        <td>{{ $orderItem->size->name}}</td>
                                        @if($orderItem->size->id == 1)
                                        <td>{{ $orderItem->pizza->pizza_small_price}}</td>
                                        @elseif($orderItem->size->id == 2)
                                        <td>{{ $orderItem->pizza->pizza_medium_price}}</td>
                                        @elseif($orderItem->size->id == 3)
                                        <td>{{ $orderItem->pizza->pizza_large_price}}</td>
                                        @endif
                                        <td>
                                            <img src="{{ asset(str_replace('storage', 'storage', $orderItem->pizza->pizza_image)) }}" alt="Pizza Image" style="width: 100px; height: auto;">
                                        </td>
                                    </tr>
                                    @endforeach
                                    
                                    @else
                                    <p>Cart is Empty</p>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">{{__('Order')}}</div>
                        <div class="card-body d-flex align-items-center">
                            <h1 class="flex-grow-1">Total Cost: £{{$orderTotal}}</h1>
                            <form action="{{ route('cart.checkout')}}" method="POST" class="d-inline ml-auto">
                                @csrf
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="delivery_method" id="delivery" value="1" checked>
                                    <label class="form-check-label" for="delivery">Delivery</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="delivery_method" id="collection" value="2">
                                    <label class="form-check-label" for="collection">Collection</label>
                                </div>
                                <button type="submit" class="btn btn-primary ml-2">Re-Order</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
