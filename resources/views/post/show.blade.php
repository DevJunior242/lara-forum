@extends('layout.app')
<x-nav/>
@section('content')
<div class="container mt-4">

    <div>
        @if (session('success'))
        <div class="alert alert-success" role="alert">

            <span>{{ session("success") }}</span>

        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">

            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"> </button>
        </div>
        @endif
    </div>
    <div class="p-4 bg-white border rounded-lg shadow-2xl text-zinc-900 border-slate-900">
        <div class="flex justify-between bg-white border-b rounded-sm shadow-sm md:flex-row border-slate-900">
            @if (in_array(pathinfo($post->path, PATHINFO_EXTENSION), ['jpg', 'png', 'jpeg', 'gif']))
            <img class="w-40 h-40 transition-all duration-300 transform rounded-full cursor-pointer hover:-translate-x-2"
                src="{{asset('storage/'.$post->path)}}" alt="">

            @elseif (in_array(pathinfo($post->path, PATHINFO_EXTENSION), ['mp4', 'mov', 'avi', 'mkv', 'webm']))
            <div class="overflow-hidden transition-all duration-300 transform bg-white rounded-lg shadow-lg cursor-pointer w-72 h-72 hover:translate-x-1">
                <video controls class="w-64 h-64 rounded-sm cursor-pointer">
                    <source src="{{asset('storage/'.$post->path)}}"
                        type="video/{{ pathinfo($post->path, PATHINFO_EXTENSION) }}">
                    votre navigateur ne supporte pas
                </video>
            </div>
         
            @else
            <p>aucun fichier</p>
            @endif
            <div class="flex justify-between">
                <div class="flex flex-col justify-center">
                    <h1 class="text-3xl text-center uppercase text-slate-900 fw-bold ">{{ $post->title }}</h1>
                    <p class="text-center text-slate-900 fw-bold">{{ $post->content }}</p>

                </div>
                <div>
                    @if (Auth::user()->id == $post->user_id)
                    <a href="{{ url('postEdit/'.Hashids::connection('main')->encode($post->id). '/main') }}"
                        class="mx-2 text-4xl text-green-500 hover:text-green-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path
                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                            <path fill-rule="evenodd"
                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                        </svg>
                    </a>
                    <a href="{{ url('postDelete/'.Hashids::connection('main')->encode($post->id). '/main') }}"
                        class="text-red-500 hover:text-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            class="bi bi-trash" viewBox="0 0 16 16">
                            <path
                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                            <path
                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                        </svg>
    
                    </a>
                    @endif
                </div>
             
            </div>

        </div>

      

    </div>

</div>
@include('comment._comment')
@include('post.comment')
@endsection

