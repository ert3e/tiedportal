@extends('layout.master')

@include('macros.form')
@include('macros.messages')

@section('controls')
    <div class="btn-group pull-right m-t-15">
        <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Actions <span class="m-l-5"><i class="fa fa-wrench"></i></span></button>
        <ul class="dropdown-menu" role="menu">
            <li>
                <a href="#add-notification-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add notification</a>
            </li>
        </ul>
    </div>
@endsection

@section('content')

    @include('fragments.page.header')

    @macro('errors')
    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <h2>Notifications</h2>
                <table class="table">
                    <tr><th class="empty-note-priority">Content</th><th>Status</th></tr>
                @foreach($notifications as $n)
                    <tr>
                        <td class="{{ strtolower($n->priority) }}-note-priority">{{$n->content}}</td>
                        <td>{{$n->status}}</td>
                    </tr>
                @endforeach
                </table>
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
    @embed('fragments.page.modal', ['id' => 'add-notification-modal', 'route' => 'notifications.store', 'files' => false, 'title' => 'Add notification' , 'button' => trans('global.save')])

        @section('content')

            {!! Form::hidden('status', 0) !!}
            {{--  @macro('text_title', 'name', 'Company name')  --}}
            @macro('textarea_title', 'content', 'Notification content')
            @macro('select_title', 'priority', [ 'Low', 'Medium', 'Hight' ], 'Priority')

        @endsection

    @endembed
@endsection