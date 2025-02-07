@if($notifications->isEmpty())
<p>Aucune notification pour le moment.</p>
@else
@foreach ($notifications as $notification)
<li class="list-group-item">
    <strong>{{ $notification->data['user']['name'] }}</strong> a répondu :
    <p>"{{ $notification->data['comment'] }}"</p>
    <small>{{ \Carbon\Carbon::parse($notification->data['repliedTime'])->diffForHumans() }}</small>

    @if(isset($notification->data['comment_id']))
    <a href="{{ route('comments.show', $notification->data['comment_id']) }}" class="btn btn-primary btn-sm">Voir</a>
    @endif

    <!-- Marquer comme lue -->
    <form action="{{ route('read', $notification->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-success btn-sm">Marquer comme lu</button>
    </form>
</li>
@endforeach
@endif

