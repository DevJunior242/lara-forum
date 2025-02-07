@extends('layout.app')


@section('content')

<div class="container mt-4">
    @if (session('success'))
    <div class="alert alert-success" role="alert">

        <span>{{ session("success") }}</span>

    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <span>{{ $error }}</span>
        @endforeach
    </div>
    @endif
    <div class="row justify-content-center align-items-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header  text-3xl">modifier votre mot de passe</div>
                <div class="card-body">
                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        @method('post')
                        <div class="form-group">
                            <input type="hidden" name="token" value="{{ $token }}">
                        </div>
                        <div class="form-group mt-4">
                            <input type="email" name="email" required class="form-control"
                                placeholder="devjunior@gmail.com" value="{{ old('email') }}">
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mt-4">

                            <input type="password" name="password" class="form-control" placeholder="password"
                                value="{{ old('password') }}" required>
                            @error('password')
                            <span class="text-danger  ">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mt-4">

                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="password_confirmation" value="{{ old('password_confirmation') }}" required>
                            @error('password_confirmation')
                            <span class="text-danger  ">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mt-4">

                            <button class="btn btn-success form-control">mettre à jour!</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection