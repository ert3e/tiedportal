<li>
    <img src="{!! $assignee->imageUrl(60, 60) !!}" alt="{{ FieldRenderer::userDisplay($assignee) }}" title="{{ FieldRenderer::userDisplay($assignee) }}" class="thumb-sm" />
    <span class="tran-text">{!! FieldRenderer::user($assignee) !!}</span>
    <span class="pull-right">
        <button class="btn btn-sm fa fa-trash btn-danger delete-user" data-id="{{ $assignee->id }}"></button></span>
    <span class="clearfix"></span>
</li>