<h4 class="m-t-0 header-title"><b>Activity</b></h4>
<div class="p-20">
    <div class="timeline-2">
        @foreach( $object->events->take(10) as $event )
            <div class="time-item">
                <div class="item-info">
                    <div class="text-muted">{!! TimelineRenderer::time($event) !!}</div>
                    <p>{!! TimelineRenderer::user($event) !!} {!! TimelineRenderer::description($event) !!}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>