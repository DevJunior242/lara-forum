@extends('layout.app')

@section('content')
    <div class="container">
        <h1>editer un commentaire</h1>
        <form action="{{ route('updateComment', $comment->id) }}" method="POST">
          @csrf
          <input type="hidden" name="parent_id" value="{{ $comment->id }}">
          <textarea name="content"  cols="20" rows="5"></textarea>
            <button class="px-4 py-1 bg-green-500 rounded-lg">metre à jour</button>
        </form>
    </div>
@endsection