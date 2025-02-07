
<div class="flex justify-items-start">
    @foreach ($user as $u)
    @if (Cache::has('user-is-online-' .$u->id))
    <b class="">{{ $u->name }} <span class="p-4 bg-green-500">(en ligne)</span> </b>
    @else
    <b>{{ $u->name }} (hors ligne)</b>
    @endif
    @endforeach
</div>


    {{-- <div class="left-0 flex flex-col">
        @foreach ($user as $u)
        @if (auth()->check() && auth()->id() === $u->id)
        <b>{{ $u->name }} (en ligne)</b>
        @else
        <b>{{ $u->name }} (hors ligne)</b>
        @endif
        @endforeach
    </div>
    --}}
    {{--
    <div class="flex justify-items-start">
        @foreach ($user as $u)
        @if (Cache::has('user-is-online-' .$u->id))
        <b>{{ $u->name }} (en ligne)</b>
        @else
        <b>{{ $u->name }} (hors ligne)</b>
        @endif
        @endforeach
    </div> --}}