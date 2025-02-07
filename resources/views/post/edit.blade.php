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
            <div class="p-4 border rounded-lg shadow-2xl card bg-slate-100 text-slate-900 border-slate-900">
                <div class="text-3xl text-center uppercase card-header text-slate-950 fw-bold">mettre à jour un post
                </div>
                <div class="card-body">
                    <form action="{{ url('postUpdate/'.Hashids::connection('main')->encode($post->id). '/main') }}"
                        enctype="multipart/form-data" method="POST"
                        class="p-4 border rounded-lg shadow-inner text-slate-900 border-slate-900">
                        @csrf
                        @method('post')


                        <div class="mt-4 form-group">

                            <input type="text" name="title" class="form-control" value="{{ $post->title }}"
                                placeholder="title">
                            @error('title')
                            <span class="text-danger ">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mt-4 form-group">

                            <input type="text" name="content" value="{{ $post->content }}" class="form-control"
                                placeholder="content">
                            @error('content')
                            <span class="text-danger ">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mt-2 form-group">
                            @if (in_array(pathinfo($post->path, PATHINFO_EXTENSION), ['jpg', 'png', 'jpeg', 'gif']))
                            <img src="{{asset('storage/'.$post->path)}}" alt="">

                            @elseif (in_array(pathinfo($post->path, PATHINFO_EXTENSION), ['mp4', 'mov', 'avi', 'mkv',
                            'webm']))
                            <video controls style="width:500px; height:500px;">
                                <source src="{{asset('storage/'.$post->path)}}"
                                    type="video/{{ pathinfo($post->path, PATHINFO_EXTENSION) }}">
                                votre navigateur ne supporte pas
                            </video>
                            @else
                            <a href="{{ asset('storage/'.$post->path) }}" download="{{ $post->title }}">{{
                                $post->title }}</a>
                            @endif
                        </div>
                        <div class="mt-4 form-group">

                            <input type="file" name="file" id="file">
                            @error('file')
                            <span class="text-danger ">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4 form-group">

                            <button class="btn btn-success form-control">mettre à jour</button>

                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection