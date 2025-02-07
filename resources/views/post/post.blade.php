@extends('layout.app')
<x-nav />

@section('content')
 
<div class="container mt-4">
     @if (session('success'))
    <div class="alert alert-success" role="alert">
       
            <span>{{ session("success") }}</span>
       
    </div>
    @endif
     
    <div class="row justify-content-center align-items-center ">
    
       
        <div class="col-md-8">
            <div class="p-4 border rounded-lg shadow-lg card bg-slate-100 text-slate-900 border-slate-900">
                <div class="text-3xl text-center uppercase card-header text-slate-950 fw-bold">ajouter un post</div>
                <div class="card-body">
                    <form action="{{ url('postStore') }}" enctype="multipart/form-data" method="POST" class="p-4 border rounded-lg shadow-lg text-slate-900 border-slate-900">
                        @csrf
                        @method('post')
                         
                       
                        <div class="p-4 mt-4 border rounded-lg shadow-lg form-group bg-slate-100 text-slate-900 border-slate-900">

                            <input type="text" name="title" class="form-control" placeholder="title" >
                            @error('title')
                            <span class="text-danger ">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="p-4 mt-4 border rounded-lg shadow-lg form-group bg-slate-100 text-slate-900 border-slate-900">

                            <input type="text" name="content" class="form-control" placeholder="content" >
                            @error('content')
                            <span class="text-danger ">{{ $message }}</span>
                            @enderror
                        </div>
                       
                        <div class="p-4 mt-4 border rounded-lg shadow-lg form-group bg-slate-100 text-slate-900 border-slate-900">

                            <input  type="file" name="file" id="file" >
                            @error('file')
                            <span class="text-danger ">{{ $message }}</span>
                            @enderror
                        </div>
                       
                        <div class="p-4 mt-4 border rounded-lg shadow-lg form-group bg-slate-100 text-slate-900 border-slate-900">

                            <button class=" text-white border border-slate-900 rounded-lg  shadow-lg text-center w-full bg-slate-900 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-500 dark:hover:border-blue-700 font-medium text-xl fw-bold py-2.5 px-5 mr-2 mb-2 ">Publish</button>

                        </div>

                         
                    </form>
                </div>
            </div>
        </div>
    </div>
 
</div>
 
@endsection