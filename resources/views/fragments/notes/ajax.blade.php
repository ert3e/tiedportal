@foreach( $notes as $note )
    @include('fragments.notes.note', ['note' => $note])
@endforeach
