@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4"> <!-- Adjusted column size to accommodate the menu -->
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
                <div class="card-header">{{ __('All Users') }}</div>
                <div class="card-body">
                    <!-- alert box to show any warnings to the user -->
                    @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message')}}
                    </div>
                    @endif
                    

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">User ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Admin?</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($users)>0)
                            @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{ $user->id }}</th>
                                <td>{{ $user->name}}</td>
                                <td>{{ $user->email}}</td>
                                <td>{{ $user->is_admin ? 'Yes' : 'No' }}</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
