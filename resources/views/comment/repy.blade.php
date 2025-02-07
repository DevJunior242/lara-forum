<div class="container mt-4">
    
            <div class="p-4 bg-white border rounded-lg shadow-2xl text-zinc-900 border-slate-900">
                <div class="flex flex-col justify-center md:flex-row">
                @if ($post->comments->isNotEmpty())
                <ul>
                   
                   @include('comment._comment', ['comment' =>$comment])
                  
                @endif
            </div>
            </div>
            
        </div>
