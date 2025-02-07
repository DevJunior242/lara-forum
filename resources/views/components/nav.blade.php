<nav class="top-0 left-0 w-full p-6 border rounded-lg shadow-2xl">

    <ul class="flex justify-between align-items-center gap-x-2">
        <li class="">
            <a class="text-xl text-blue-500 no-underline uppercase fw-bold hover:underline "
                href="{{ route('home') }}">home</a>
        </li>
        <li class="">
            <a class="text-xl text-blue-500 no-underline uppercase fw-bold hover:underline shadow-cyan-500/50 "
                href="{{ route('post') }}">About</a>
        </li>

        <li class="">
            <a class="text-xl text-blue-500 no-underline uppercase fw-bold hover:underline shadow-cyan-500/50 "
                href="#">Apropos</a>
        </li>
        <li class="">
            <a class="text-xl text-blue-500 no-underline uppercase fw-bold hover:underline shadow-cyan-500/50 "
                href="#">contact</a>
        </li>
        @guest
        <li>
            <a class="text-xl text-blue-500 no-underline uppercase fw-bold hover:underline "
                href="{{ route('register') }}">register</a>
        </li>
        @endguest
        @auth

        <li>
            <div class="relative ">
                <button id="menuButton" class="text-blue-500 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        class="text-blue-500 bi bi-bell-fill" viewBox="0 0 16 16">
                        <path
                            d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2m.995-14.901a1 1 0 1 0-1.99 0A5 5 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901" />

                    </svg>
                    <span class="absolute w-4 h-4 text-red-500 -top-4 fw-bold">
                        {{ auth()->user()->unreadNotifications->count() }}
                    </span>
                </button>
                @foreach (auth()->user()->unreadNotifications as $notification)
                <div id="submenu" class="absolute left-0 z-20 hidden w-48 mt-2 bg-white rounded-md shadow-lg">
                    {{-- @if (isset($notification->data['comment_id']))
                    @php
                    dd(route('comments.show', ['commentId' => $notification->data['comment_id']]));
                    @endphp
                    @endif --}}


                    @if (isset($notification->data['comment_id']))
                    <a href="{{ route('comments' ,$notification->data['comment_id']) }}"
                        class="block px-4 py-2 text-blue-800 hover:bg-gray-200">
                        <span class="leading-4">{{ $notification->data['user']['name'] }} a repondu:</span>&nbsp; &nbsp;
                        <span class="leading-4">{{ $notification->data['comment']}}</span>
                        <small class="leading-4">
                            {{ \Carbon\Carbon::parse($notification->data['repliedTime'])->diffForHumans() }}
                        </small>
                    </a>
                    @endif

                    <a href="{{ route('read', $notification->id) }}"
                        class="block px-4 py-2 text-gray-800 border hover:bg-gray-200">marquer comme lu</a>
                </div>
                @endforeach
            </div>
        </li>

        <li class="relative right-8">
            <div class="relative ">
                <button id="loginButton" class="flex text-xl text-blue-500 focus:outline-bg-none fw-bold">
                    {{ auth()->user()->name }}
                    <span class="absolute text-2xl top-2 -right-4 fw-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-check  viewBox=" 0 0 16 16">
                            <path
                                d="M10.854 3.646a.5.5 0 0 1 .706.708l-5.5 5.5a.5.5 0 0 1-.707 0l-2.5-2.5a.5.5 0 0 1 .707-.708L6 8.793l4.646-4.647a.5.5 0 0 1 .708 0z" />
                        </svg>

                    </span>

                </button>
                <div id="loginMenu" class="absolute left-0 z-20 hidden w-48 mt-2 bg-white rounded-md shadow-lg">

                    <a href="{{ route('logout') }}" class="block px-4 py-2 text-blue-500 hover:bg-gray-200">logout</a>
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">profile</a>
                </div>
            </div>
        </li>

        @endauth

    </ul>

</nav>
<script>
    const menuButton = document.getElementById('menuButton');
            menuButton.addEventListener('click', () => {
        const submenu = document.getElementById('submenu');
        if(submenu.classList.contains('hidden')){
            submenu.classList.remove('hidden');
        }else{
            submenu.classList.add('hidden');
        }
    })
   
    const loginButton = document.getElementById('loginButton');
            loginButton.addEventListener('click', () => {
        const loginMenu = document.getElementById('loginMenu');
        if(loginMenu.classList.contains('hidden')){
            loginMenu.classList.remove('hidden');
        }else{
            loginMenu.classList.add('hidden');
        }
    })
   
    
</script>
{{ $slot }}
<!-- The best way to take care of the future is to take care of the present moment. - Thich Nhat Hanh -->
</div>