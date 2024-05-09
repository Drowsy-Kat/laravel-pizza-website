hi
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
                        <div class="card-header">{{ __('All Pizza') }}</div>
                        <div class="card-body">
                            @if (session('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                            @endif
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Number</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Pizza Category</th>
                                        <th scope="col">Image</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($pizzas)>0)
                                    @foreach($pizzas as $pizza)
                                    <tr>
                                        <th scope="row">{{ $pizza->id }}</th>
                                        <td>{{ $pizza->pizza_name }}</td>
                                        <td>{{ $pizza->pizza_desc }}</td>
                                        <td>{{ $pizza->category->name }}</td>
                                        <td>
                                            <img src="{{ asset(str_replace('storage', 'storage', $pizza->pizza_image)) }}" alt="Pizza Image" style="width: 100px; height: auto;">
                                        </td>
                                        <td>
                                            <form action="{{ route('cart.add', $pizza->id) }}" method="POST">
                                                @csrf
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="size" id="largeSize{{ $pizza->id }}" value="large" checked>
                                                    <label class="form-check-label" for="largeSize{{ $pizza->id }}">
                                                        Large - £{{ $pizza->pizza_large_price }}
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="size" id="mediumSize{{ $pizza->id }}" value="medium">
                                                    <label class="form-check-label" for="mediumSize{{ $pizza->id }}">
                                                        Medium - £{{ $pizza->pizza_medium_price }}
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="size" id="smallSize{{ $pizza->id }}" value="small">
                                                    <label class="form-check-label" for="smallSize{{ $pizza->id }}">
                                                        Small - £{{ $pizza->pizza_small_price }}
                                                    </label>
                                                </div>
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                                        </td>
                                            </form>

                                    
                                            
                                       
                                    </tr>
                                    @endforeach
                                    @else
                                    <p>No Pizza to display</p>
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
