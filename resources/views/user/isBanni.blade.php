<div>
    <h1>utilisateur connectés</h1>
    <div class="">

        <ul class="flex gap-y-4">

            @foreach ($user as $us)
            <li>{{ $us->name }}</li>

            <li>
                
            @if ($us->isBanned())
                @if (Gate::allows('unban-user'))
                <form action="{{ route('unban', $us->id) }}" method="POST">
                    @csrf
                    <button class="text-sm bg-blue-500 ">unban</button>
                </form>
                @endif
            @else
                    @if (Gate::allows('ban-user'))
                    <form action="{{ route('ban', $us->id) }}" method="POST">
                        @csrf
                        <button class="text-sm bg-blue-500 ">ban</button>
                    </form> 
                    @endif
              
            @endif
            </li>

            @endforeach


        </ul>

    </div>
</div>