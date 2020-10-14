<div class="card-box " data-token="{{ csrf_token() }}">
    <div class="note-container">
    {!! Form::open(['route' => $route]) !!}
        <h4 class="m-t-0 m-b-30 header-title"><b>Notes</b></h4>
        {!! Form::textarea('note', null, ['class' => 'form-control note expand', 'placeholder' => 'Add a note...']) !!}
        <div class="buttons">
            <input type="hidden" name="type" id="note-type" />
              <div id="send-note" class="btn-group margin-top pull-right">
                <button value="internal" title="Add as internal note" class="btn btn-primary add-note hidden" data-loading-text="Adding note...">Internal Note</button>
                <button value="customer" title="Add as Customer" class="btn btn-primary add-note hidden" data-loading-text="Adding note..."> Customer Note</button>
                <button value="supplier" title="Add as Suplier" class="btn btn-primary add-note hidden" data-loading-text="Adding note..."> Supplier Note</button>
              </div>
              {{-- <div class="btn-group">
                <button name="type" value="internal" class="btn btn-info">Internal</button>
                <button name="type" value="customer" class="btn btn-info">Customer</button>
                <button name="type" value="suplier" class="btn btn-info">Suplier</button>
              </div>
              <button type="submit" class="btn margin-top btn-primary pull-right add-note hidden" data-loading-text="Adding note..."><i class="fa fa-send"></i> Add Note</button> --}}

        </div>
    {!! Form::close() !!}
    </div>
    <div style="clear: both"></div>
    <hr >
    <div id="notes-list-holder" data-token="{{ csrf_token() }}">
        <form class="ajax" action="{{route($search_route[0],$search_route[1])}}" method="post" data-token="{{ csrf_token() }}" data-response-selector=".ajax-response">
            <div id="switch-notes" class="btn-group margin-top form-inline">
                <input type="text" name="search" class="form-control pull-left" placeholder="Search notes for..." />
                <button value="all" name="type" title="See all notes" class="btn btn-primary active" data-loading-text="Selecting notes...">All notes</button>
                <button value="internal" name="type" title="See internal notes" class="btn btn-primary" data-loading-text="Selecting notes...">Internal notes</button>
                <button value="customer" name="type" title="See customers notes" class="btn btn-primary " data-loading-text="Selecting notes...">Customer notes</button>
                <button value="supplier" name="type" title="See supplier notes" class="btn btn-primary " data-loading-text="Selecting notes...">Supplier notes</button>
            </div>
        </form>
        <hr class="margin-top">
        <div class="p-20 p-t-0">
            <div id="notes-ajax-response" class="notes timeline-2 margin-top ajax-response">
                @foreach( $notes as $note )
                    @include('fragments.notes.note', ['note' => $note])
                @endforeach
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">
@section('script')
    $(document).ready(function(){
        $('#send-note').on('click', 'button', function(){
            var value = $(this).attr('value');
            $('#note-type').attr('value', value);
        });
    });
@endsection
</script>
