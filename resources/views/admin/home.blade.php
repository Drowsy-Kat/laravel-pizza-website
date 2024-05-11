@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
            <div class="card">
                    <div class="card-header">{{ __('Menu') }}</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ __('Pizzas') }}</h5>
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-action">
                                <a href="{{ route('pizza.index') }}" class="text-decoration-none">{{ __('View Pizzas') }}</a>
                            </li>
                            <li class="list-group-item list-group-item-action">
                                <a href="{{ route('pizza.create') }}" class="text-decoration-none">{{ __('Create Pizza') }}</a>
                            </li>
                        </ul>
                        <h5 class="card-title mt-3">{{ __('Users') }}</h5>
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-action">
                                <a href="{{ route('admin.users') }}" class="text-decoration-none">{{ __('View Users') }}</a>
                            </li>
                            <li class="list-group-item list-group-item-action">
                                <a href="{{ route('admin.user-create') }}" class="text-decoration-none">{{ __('Create User') }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
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
            </div>
        </div>
    </div>

@endsection