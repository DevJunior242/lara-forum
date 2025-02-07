@extends('layout.app')

<x-nav />

@section('content')
<div class="container relative grid grid-cols-3 gap-4 mt-20 bg-white rounded-lg shadow-xl text-zinc-900">
    @if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <span>{{ $error }}</span>
        @endforeach
    </div>
    @endif
    @foreach ($posts as $post)
    <div class="p-12 bg-white border border-slate-950 rounded-xl text-zinc-900">
        <a class="text-xl no-underline uppercase fw-bold hover:underline"
            href="{{ url('showPost/'.Hashids::connection('main')->encode($post->id) . '/main') }}">{{ $post->title
            }}</a><br><br>
        <a class="text-lg text-indigo-500 fw-bold"
            href="{{ url('showPost/'. Hashids::connection('main')->encode($post->id). '/main') }}">Lorem ipsum, dolor sit
            amet
            consectetur adipisicing elit. Obcaecati, eaque.
            <span
                class="px-1 py-0 ml-1 text-xl text-white bg-blue-800 border cursor-pointer fw-bold hover:bg-blue-400 border-blue-950 rounded-xl">voir---></span>
        </a>

    </div>
    @endforeach
</div>

<div class="flex justify-center mt-4">
    {{ $posts->links() }}
</div>

 
@endsection