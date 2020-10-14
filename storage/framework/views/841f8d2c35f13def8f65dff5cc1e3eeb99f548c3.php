    <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete delete-button-parent" data-id="<?php echo e($media->id); ?>">
        <a class="attachment <?php if( $media->isImage() ): ?> lightbox image <?php endif; ?>" data-id="<?php echo e($media->id); ?>" href="<?php echo e(route('media.download', $media->id)); ?>" target="_blank">
        <a href="<?php echo e(route('media.download', $media->id)); ?>" target="_blank" class="download-attachment btn btn-sm btn-primary fa fa-download"></a>
        <button class="delete-attachment btn btn-sm btn-danger fa fa-trash"></button>
        <div class="dz-image">
            <img src="<?php echo e(FieldRenderer::preview($media)); ?>" />
        </div>
        <div class="dz-details">
            <div class="dz-size">
                <span>
                    <?php echo e(FieldRenderer::formatDate($media->created_at, true)); ?><br/>
                    <?php echo e(FieldRenderer::formatBytes($media->size)); ?>

                </span>
            </div>
            <div class="dz-filename">
                <span><?php echo e($media->name); ?></span>
            </div>
        </div>
    </a>
    </div>
