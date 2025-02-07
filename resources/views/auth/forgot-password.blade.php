@extends('layout.app')
<div class="container mt-4">
    @if (session('success'))
    <div class="alert alert-success mt-2">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger mt-2">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="form-group">
            <input type="email" name="email" id="email"  value="devpaypal677@gmail.com"  class="form-control" required autofocus>
        </div>
        <div class="form-group mt-2">
            <button class="btn btn-primary form-control">send password resend link</button>
        </div>
    </form>
</div>