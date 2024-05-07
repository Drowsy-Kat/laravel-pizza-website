@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

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


                
                @if(count($errors) > 0)
                    <div class="card m-5">
                        <div class="card-body">
                            
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger">{{ $error }}</div>
                                @endforeach
                            
                        </div>
                    </div>
                @endif
                @if (session('message'))
                    <div class="row justify-content-center mt-4">
                        <div class="col-md-8">
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Register New User')}}</div>

                        <form action="{{ route('admin.register') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="name">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="name@example.com">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="password">
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                </div>
                                <div class="form-group">
                                    <label for="is_admin">Admin?</label>
                                    <input type="hidden" name="is_admin" value="0"> <!-- Hidden input for when checkbox is unchecked -->
                                    <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin" value="1"> <!-- Checkbox input for when it's checked -->
                                </div>
                                <div class="form-group text-center">
                                    <button class="btn btn-primary" type="submit">Register</button>
                                </div>
                            
                                
                            </div>


                        </form>
                    </div>
                </div>
            
        </div>

    </div>

@endsection