@extends('layout.app')



<div class="container">

    <div
        class="flex flex-col items-center justify-center mt-56 bg-white shadow-2xl rounded-3xl " style="width: 590px; height:550px; margin:auto">
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
        <h1 class="text-xl text-blue-500 uppercase fw-bold">connexion</h1>
        <div class="" >
       
        <form action="{{ url('loginUpdate') }}" enctype="multipart/form-data" method="POST">
            @csrf
            @method('post')
            
            <div class="w-full bg-white border shadow-xl rounded-xl border-slate-200 ">
                <input type="email" name="email" required class="w-full py-4 text-blue-500" placeholder="devjunior@gmail.com"
                    value="{{ old('email') }}">
                @error('email')
                <span class="text-danger">{{ $message }}</span>
                @enderror

            </div>


            <div class="w-full mt-4 bg-white shadow-xl rounded-xl">
                <input type="password" name="password" value="{{ old('password') }}" class="w-full py-4 text-blue-500"
                    placeholder="password" required>
                @error('password')
                <span class="text-danger ">{{ $message }}</span>
                @enderror

            </div>


            <div class="flex justify-between mt-4">
                
                <a href="{{ route('auth.google') }}">
                    <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png">
                </a>
                <a href="{{ route('password.request') }}" class="text-sm text-blue-500 underline">mot de pass oublié?</a>

            </div>




            <div class="mt-4">
                <button class="py-4 text-white bg-blue-500 rounded-lg px-52 ">se connecter!</button>

            </div>
    <div class="flex justify-between mt-2">
        <p class="text-sm text-blue-500">pas de compte?</p>
        <a href="{{ route('register') }}" class="text-sm text-blue-500 underline">créer un compte</a>
    </div>
        </form>
    </div>
    </div>








</div>
 