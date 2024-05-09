@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4">
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
                                        <th scope="col">Large Price</th>
                                        <th scope="col">Medium Price</th>
                                        <th scope="col">Small Price</th>
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
                                        <td>{{ $pizza->pizza_large_price }}</td>
                                        <td>{{ $pizza->pizza_medium_price }}</td>
                                        <td>{{ $pizza->pizza_small_price }}</td>
                                        <td>
                                            <img src="{{ asset(str_replace('storage', 'storage', $pizza->pizza_image)) }}" alt="Pizza Image" style="width: 100px; height: auto;">
                                        </td>
                                        <td><a href="{{route('pizza.edit',$pizza->id)}}"><button class="btn btn-primary">Edit</button></a></td>
                                        <td><button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal{{$pizza->id}}">>Delete</button></td>
                                        <div class="modal fade" id="exampleModal{{$pizza->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <form action="{{route('pizza.destroy', $pizza->id)}}" method="post">@csrf
                                                @method('delete')
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Delete confirmation</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body"> Are you sure? </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
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
