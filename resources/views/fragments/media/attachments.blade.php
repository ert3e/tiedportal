<div class="card-box attachments-container hidden">
    <h4 class="m-t-0 m-b-30 header-title"><b>Attachments</b></h4>
    <div class="attachments">
        @foreach( $object->attachments as $media )
            @include('fragments.media.attachment')
        @endforeach
    </div>
</div>