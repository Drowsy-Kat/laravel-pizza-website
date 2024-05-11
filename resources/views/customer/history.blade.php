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
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Order History') }}</div>
                        <div class="card-body">
                            @if (session('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                            @endif
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Order ID</th>
                                        <th scope="col">Delivery Method</th>
                                        <th scope="col">Order Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($orders)>0)
                                        @foreach($orders as $order)
                                            <tr onclick="window.location='{{ route('customer.order', ['id' => $order->id]) }}';" style="cursor:pointer;">
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->deliveryMethod->name }}</td>
                                                <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                            </tr>
                                       @endforeach
                                    @else
                                    <tr>
                                        <td colspan="3">No Previous Orders</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
