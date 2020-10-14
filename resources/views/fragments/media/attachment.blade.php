    <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete delete-button-parent" data-id="{{ $media->id }}">
        <a class="attachment @if( $media->isImage() ) lightbox image @endif" data-id="{{ $media->id }}" href="{{ route('media.download', $media->id) }}" target="_blank">
        <a href="{{ route('media.download', $media->id) }}" target="_blank" class="download-attachment btn btn-sm btn-primary fa fa-download"></a>
        <button class="delete-attachment btn btn-sm btn-danger fa fa-trash"></button>
        <div class="dz-image">
            <img src="{{ FieldRenderer::preview($media) }}" />
        </div>
        <div class="dz-details">
            <div class="dz-size">
                <span>
                    {{ FieldRenderer::formatDate($media->created_at, true) }}<br/>
                    {{ FieldRenderer::formatBytes($media->size) }}
                </span>
            </div>
            <div class="dz-filename">
                <span>{{ $media->name }}</span>
            </div>
        </div>
    </a>
    </div>
