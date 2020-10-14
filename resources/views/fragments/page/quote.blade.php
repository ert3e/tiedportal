<div class="widget-bg-color-icon card-box">
    <div class="text-left">
        <h5 class="text-dark">{{ FieldRenderer::formatDate($quote->created_at) }}</h5>
        <p class="text-muted">Cost: <strong>{{ FieldRenderer::formatCurrency($quote->cost) }} {{{ $quote->includes_vat ? ' (inc VAT)' : '(ex VAT)' }}}</strong></p>
        @if( strlen($quote->reference) )
            <p class="text-muted">Reference: <strong>{{ $quote->reference }}</strong></p>
        @endif
        @if( strlen($quote->message) )
            <p class="text-muted">Message: <strong>{{ $quote->message }}</strong></p>
        @endif
        @foreach( $quote->media as $media )
            <p class="text-muted"><a href="{{ route('media.download', $media->id, str_slug($media->name)) }}" title="{{ $media->name }}" target="_blank">Download {{ $media->name }}</a></p>
        @endforeach
    </div>
    <div class="clearfix"></div>
</div>