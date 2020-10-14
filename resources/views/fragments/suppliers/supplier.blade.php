<li>
    <img src="{!! $supplier->imageUrl(60, 60) !!}" alt="{{ $supplier->name }}" title="{{ $supplier->name  }}" class="thumb-sm" />
    <span class="tran-text"><a href="{{ route('suppliers.details', $supplier->id) }}">{{ $supplier->name }}</a></span>
    <span class="pull-right">
        <button class="btn btn-sm fa fa-trash btn-danger delete-supplier" data-id="{{ $supplier->id }}"></button></span>
    <span class="clearfix"></span>
</li>