@extends('layout.master')

@include('macros.form')
@include('macros.messages')

@section('controls')
    @if( Permissions::has('settings', 'create') )
        <div class="btn-group pull-right m-t-15">
            <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Actions <span class="m-l-5"><i class="fa fa-wrench"></i></span></button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="#add-setting-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add {{ str_singular($title) }}</a>
                </li>
            </ul>
        </div>
    @endif
@endsection

@section('content')

    @include('fragments.page.header')

    @macro('errors')

    <div class="row">
        <div class="col-lg-12">
            <p>{{ $title }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <div class="row">
                    <div class="table-responsive">

                        @if( count($items) )
                            <table class="table table-hover m-0 table table-actions-bar">
                                <thead>
                                <tr>
                                    @foreach( $fields as $field )
                                        <th>{{ $field['name'] }}</th>
                                    @endforeach
                                    <th style="width: 105px">Action</th>
                                </tr>
                                </thead>

                                <tbody>

                                    @foreach( $items as $item )
                                        <tr id="#item-{{ $item->id }}">
                                            @foreach( $fields as $key => $field )
                                                @if( $field['type'] == 'image' )
                                                    <td style="width: 100px;">
                                                    @if( is_object($item->$key) )
                                                        <img src="{!! route('media.get', [$item->$key->id, 100, 100]) !!}" class="img-circle thumb-sm" />
                                                    @endif
                                                    </td>
                                                @elseif( $field['type'] == 'text' )
                                                    <td>{{ $item->$key }}</td>
                                                @elseif( $field['type'] == 'colour' )
                                                    <td style="width: 80px"><div class="colour-display" style="background: #{{ $item->$key }};"></div></td>
                                                @elseif( $field['type'] == 'textarea' )
                                                    <td>{{ $item->$key }}</td>
                                                @elseif( $field['type'] == 'select' )
                                                    <td>{{ $item->{$field['value']}() }}</td>
                                                @endif
                                            @endforeach
                                            <td>
                                                <button title="Delete" data-title="Delete {{ str_singular($title) }}" data-message="Are you sure you want to delete this {{ strtolower(str_singular($title)) }}? This action cannot be undone!" data-confirm="{{ strtolower(str_singular($title)) }} deleted!" data-element="#item-{{ $item->id }}" data-href="{{ route('settings.delete', ['type' => $type, 'id' => $item->id, '_token' => csrf_token()]) }}" class="btn btn-danger delete-button waves-effect waves-light"><i class="fa fa-trash"></i></button>
                                                <button href="{{ route('settings.edit', [$type, $item->id]) }}" title="Edit" class="btn btn-default waves-effect waves-light" data-animation="fadein" data-plugin="ajaxmodal" data-target="#modal-container"
                                                   data-overlaySpeed="200" data-overlayColor="#36404a"><i class="fa fa-pencil"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        @else
                            <p><em>No {{ strtolower($title) }} found.</em></p>
                        @endif
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>

    @embed('fragments.page.modal', ['id' => 'add-setting-modal', 'route' => ['settings.store', $type], 'files' => false, 'title' => 'Add ' . str_singular($title), 'button' => trans('global.save')])

        @section('content')

            @foreach( $fields as $key => $field )

                @if( $field['type'] == 'text' )
                    @macro('text_title', $key, $field['name'])
                @elseif( $field['type'] == 'textarea' )
                    @macro('textarea_title', $key, $field['name'])
                @elseif( $field['type'] == 'colour' )
                    @macro('colour_title', $key, $field['name'])
                @elseif( $field['type'] == 'image' )
                    @macro('image_title', $key, $field['name'])
                @elseif( $field['type'] == 'select' )
                    @macro('select_title', $key, $field['values'], $field['name'])
                @endif

            @endforeach

        @endsection
    @endembed

    <div id="modal-container" class="modal-demo"></div>

@endsection
