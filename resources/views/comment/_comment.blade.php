 

  <!DOCTYPE html>
  <html lang="en">
  <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>forum</title>
     <link rel="stylesheet" href="{{ asset('css/style.css') }}">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> 
     @vite('resources/css/app.css')
  </head>
   
  <body class="bg-white ">
    

<div class="container mt-4">
    <div class="p-4 mt-4 mb-4 bg-white border rounded-lg shadow-xl border-zinc-900">
        <h2 class="text-xl font-semibold">Commentaires</h2>



        @forelse ($post->comments as $comment)
        <div class="p-4 mt-4 bg-white border rounded-lg shadow-2xl border-zinc-900">
            <div class="p-4 rounded-lg shadow-md bg-neutral-50">
                @if ($comment->parent_id == null)
                <p class="text-sm text-blue-500 fw-bold">{{ $comment->content }}</p>
                <strong class="mt-2 text-xl text-zinc-900 fw-bold">
                    Commenté par {{ $comment->user->name }} le {{ $comment->created_at->format('d/m/Y') }} à
                    {{ $comment->created_at->format('H:i') }} depuis {{ auth()->user()->city ?? 'Non renseigné' }}
                </strong>
                <div class="flex justify-end space-x-4">
                    @if (auth()->user()->id == $comment->user_id)
                    <button class="text-sm text-green-500 edit-button" data-edit-id="{{ $comment->id }}">editer</button>
                    <form action="{{ route('updateComment', ['commentId' =>$comment->id])}}" method="POST"
                        id="edit-form-{{ $comment->id }}" class="hidden mt-4 edit-form">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <textarea name="content" id="" cols="30" rows="3"
                            class="text-zinc-900">{{ $comment->content }}</textarea>
                        <button class="text-white bg-green-500 rounded-sm shadow-lg">mettre à jour</button>
                    </form>
                    <form action="{{ route('comments.delete', ['commentId' =>$comment->id]) }}" method="POST" onclick="return confirm('Etes vous sur de vouloir supprimer ce commentaire?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="p-2 text-red-800 rounded-lg hover:text-red-bg-red-900">supprimér</button>
                    </form>
                    @endif

                </div>

            </div>

            <div class="flex items-center justify-between">
                <!-- Bouton Like -->
                <form action="{{ route('commentLike', ['comment' => $comment->id]) }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center space-x-2 text-gray-600 hover:text-green-500">
                        @if ($comment->likes->contains('user_id', auth()->user()->id))
                        <svg class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5" />
                        </svg>
                        @else
                        <svg class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                        </svg>
                        @endif
                        <span>{{ $comment->likes->count() }}</span>
                    </button>
                </form>

                {{--
                <!-- Bouton Répondre à un commentaire -->--}}
                <button class="text-sm text-blue-500 hover:text-blue-700 reply-button"
                    data-reply-id="{{ $comment->id }}">
                    Répondre
                </button>
            </div>

        </div>

        @endif
        <!-- Formulaire pour répondre au commentaire -->
        <form action="{{ route('reply', ['commentId' => $comment->id]) }}" method="POST" class="hidden mt-4 reply-form"
            id="reply-form-{{ $comment->id }}">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
            <textarea name="content" class="w-full p-2 mt-2 border rounded-lg" rows="3" required></textarea>
            <button type="submit" class="p-2 mt-2 text-white bg-blue-500 rounded-lg">Répondre</button>
        </form>

        <!-- Affichage des réponses -->
        @if($comment->replies->isNotEmpty())
        @foreach ($comment->replies as $reply)

        <div class="p-4 mt-4 ml-4 rounded-lg shadow-md bg-zinc-900 text-zinc-100">



            <div class="flex justify-between">
                <strong>Réponse à {{ $reply->parent->user->name }}</strong>
                <p class="mt-2 text-sm">{{ $reply->content }}</p>

            </div>




            <div class="flex justify-between mt-4">
                <form action="{{ route('replyLike', ['reply' => $reply->id]) }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center space-x-2 text-gray-600 hover:text-green-500">
                        @if ($reply->likes->contains('user_id', auth()->user()->id))
                        <svg class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5" />
                        </svg>
                        @else
                        <svg class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                        </svg>
                        @endif
                        <span>{{ $reply->likes->count() }}</span>
                    </button>
                </form>
                @if ($reply->user->id == Auth::id())


                <button class="text-sm text-blue-500 edit-reply-form"
                    data-editReply-id="{{ $reply->id }}">editer</button>
                <div>
                    <form action="{{ route('updateComment', ['commentId' =>$reply->id]) }}" method="POST"
                        class="hidden mt-4 edit-reply-form" id="edit-reply-form-{{ $reply->id }}">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $reply->id }}">
                        <textarea name="content" id="" cols="30" rows="3"
                            class="text-zinc-900">{{ $reply->content }}</textarea>
                        <button class="bg-green-500 rounded-sm shadow-sm">mettre à jour</button>
                    </form>
                    <form action="{{ route('deleteComment',['commentId' =>$reply->id]) }}" method="POST">
                        @csrf
                        <button class="text-sm text-red-500">supprimer</button>
                    </form>
                </div>
                @endif
                <button class="text-sm text-blue-500 hover:text-blue-700 ReplyReplyButton"
                    data-reply-id="{{ $reply->id }}">Répondre</button>
            </div>

            <!-- Formulaire pour répondre à une réponse -->
            <form action="{{ route('reply', ['commentId' => $reply->id])}}" method="POST"
                class="hidden mt-4 reply-reply-form" id="reply-reply-form-{{ $reply->id }}">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $reply->id }}">
                <textarea name="content" class="w-full p-2 mt-2 border rounded-lg text-zinc-900" rows="3"
                    required></textarea>
                <button type="submit" class="p-2 mt-2 text-white bg-blue-500 rounded-lg">Répondre</button>
            </form>
        </div>

        @endforeach
        @endif
        @empty
        <div class="flex justify-between">
            <p class="text-gray-600">Aucun commentaire pour ce post.</p>


        </div>

        @endforelse

    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function(){
        document.querySelectorAll('.edit-reply-form').forEach(button =>{
            button.addEventListener('click', function(){
                let editId = this.getAttribute('data-editReply-id');
                let editForm =  document.getElementById(`edit-reply-form-${editId}`);
                if (editForm.classList.contains('hidden')) {
                    // Masquer tous les autres formulaires de réponse
                    document.querySelectorAll('.edit-reply-form').forEach(form => form.classList.add('hidden'));
                    editForm.classList.remove('hidden');
                } else {
                    editForm.classList.add('hidden');
                }
            } )
        })
    });
    
    document.addEventListener('DOMContentLoaded', function(){
        document.querySelectorAll('.edit-button').forEach(button =>{
            button.addEventListener('click', function(){
                let editId = this.getAttribute('data-edit-id');
                let editForm =  document.getElementById(`edit-form-${editId}`);
                if (editForm.classList.contains('hidden')) {
                    // Masquer tous les autres formulaires de réponse
                    document.querySelectorAll('.edit-form').forEach(form => form.classList.add('hidden'));
                    editForm.classList.remove('hidden');
                } else {
                    editForm.classList.add('hidden');
                }
            } )
        })
    });
    
    document.addEventListener('DOMContentLoaded', function () {
  
        document.querySelectorAll('.reply-button').forEach(button => {
            button.addEventListener('click', function () {
                let replyId = this.getAttribute('data-reply-id');
                let replyForm = document.getElementById(`reply-form-${replyId}`);

                if (replyForm.classList.contains('hidden')) {
                    // Masquer tous les autres formulaires de réponse
                    document.querySelectorAll('.reply-form').forEach(form => form.classList.add('hidden'));
                    replyForm.classList.remove('hidden');
                } else {
                    replyForm.classList.add('hidden');
                }
            });
        });

    
        document.querySelectorAll('.ReplyReplyButton').forEach(button => {
            button.addEventListener('click', function () {
                let replyId = this.getAttribute('data-reply-id');
                let replyReplyForm = document.getElementById(`reply-reply-form-${replyId}`);

                if (replyReplyForm.classList.contains('hidden')) {
             
                    document.querySelectorAll('.reply-reply-form').forEach(form => form.classList.add('hidden'));
                    replyReplyForm.classList.remove('hidden');
                } else {
                    replyReplyForm.classList.add('hidden');
                }
            });
        });
    });


    const button = document.getElementById('replyButton');
    const form = document.getElementById('replyForm');
    button.addEventListener('click', () =>{
        if(form.style.display === 'none' || form.style.display == ''){
            form.style.display = 'block';
            button.innerText = 'fermer';
        }else{
            form.style.display = 'none';
            button.innerText = 'ouvrir';
        }
    })
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  
  
</body>
</html>
