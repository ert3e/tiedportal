<div class="widget-bg-color-icon card-box" style="border: solid 2px #{{ $component->componentType->colour }}">
    <div class="text-left">
        <h5 class="text-dark">{{ $component->name }}</h5>
        <p class="text-muted">
            @foreach( $component->values as $value )
                {!! FieldRenderer::render($value) !!}<br/>
            @endforeach
        </p>
    </div>
    <div class="clearfix"></div>
</div>