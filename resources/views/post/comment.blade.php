<style>
    #replyForm {
        display: none;
    }
</style>

<div class="container mt-4">
   
    <div class="p-4 bg-white border rounded-lg shadow-2xl text-slate-500 border-slate-900">
        <div class="flex justify-between">
            <h1 class="text-xl text-center uppercase text-slate-900 fw-bold ">Entrez dans le forum de discussion </h1>
            <button   class="text-sm text-blue-500 rounded-lg shadow-xl hover:bg-blue-700 post-comment-button" data-post-id="{{ $post->id }}">
            créer un commentaire
            </button>
        </div>

        <div class="flex flex-col "  >

            <form action="{{ route('comment', $post->id)}}" method="POST" class="hidden post-comment-button " id="post-comment-button-{{ $post->id }}">
                @csrf
                @method('post')


                <div>
                    <textarea class="py-10 rounded-lg shadow-2xl px-96 text-zinc-800" name="content" cols="30" rows="3"
                        required></textarea>
                    @error('content')
                    <span class="text-danger ">{{ $message }}</span>
                    @enderror
                </div>


                <button
                    class="py-4 mt-4 ml-24 text-2xl text-white uppercase bg-blue-500 rounded-lg shadow-xl hover:bg-slate-400 px-96">commentez!</button>


            </form>

        </div>
    </div>

</div>

<script>
  document.addEventListener('DOMContentLoaded', function(){
     document.querySelectorAll('.post-comment-button').forEach(button => {
        button.addEventListener('click', function(){
            let postId = this.getAttribute('data-post-id');
            let postForm = document.getElementById(`post-comment-button-${postId}`);
            
            if(postForm.classList.contains('hidden')){
                document.querySelectorAll('.post-comment-button').forEach(form => form.classList.add('hidden'));
                postForm.classList.remove('hidden');
                
            }else{
                postForm.classList.add('hidden');
            }
        })
     })
  })
</script>

