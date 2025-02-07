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
                <div class="text-3xl card-header">sign in</div>
                <div class="card-body">
                    <form action="{{ url('registerPost') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        @method('post')
                        <div class="mt-4 form-group">

                            <input type="text" name="name" class="p-2 form-control"
                                placeholder="veuillez saisir votre nom ici..." required>
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                     
                        <div class="mt-4 form-group">
                            <input type="email" name="email" required class="form-control" placeholder="devjunior@gmail.com">
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                       
                        <div class="mt-4 form-group">

                            <input type="password" name="password" class="form-control" placeholder="password" required>
                            @error('password')
                            <span class="text-danger ">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mt-4 form-group">

                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="password_confirmation" required>
                            @error('password_confirmation')
                            <span class="text-danger ">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mt-4 form-group">

                            <input type="text" name="country" class="form-control" placeholder="country" required>
                            @error('country')
                            <span class="text-danger ">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mt-4 form-group">

                            <input type="text" name="city" class="form-control" placeholder="city" required>
                            @error('city')
                            <span class="text-danger text-muted ">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mt-4 form-group">

                            <input type="file" name="image" id="image">
                            @error('image')
                            <span class="text-danger ">{{ $message }}</span>
                            @enderror
                        </div>
                       
                        <div class="mt-4 form-group">

                            <button class="btn btn-success form-control">register</button>

                        </div>

                        <div class="mt-4 text-center fomr-group">
                            <span>avez-vous dejà un compte ? </span>   <a href="{{ url('login') }}">login</a>
                           </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection