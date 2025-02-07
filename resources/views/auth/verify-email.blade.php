@extends('layout.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-uppercase text-success">please verifry your email address</div>
                <div class="card-body">
                    <form action="{{ route('verification.send') }}" method="POST">
                   @csrf
                    <div class="form-group">
                        <button class="btn btn-success form-control">send verification link</button>
                    </div>
                          
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection