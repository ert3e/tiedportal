@macrodef('text', $name, $value = "", $opts = ['class' => 'form-control'], $addon = '')
<div class="input-group">
    <span class="input-group-addon">{!! $addon !!}</span>
    {!! Form::text($name, $value, $opts) !!}
</div>
@endmacro

@macrodef('email', $name, $value = "", $opts = ['class' => 'form-control'], $addon = '@')
<div class="input-group">
    <span class="input-group-addon">{!! $addon !!}</span>
    {!! Form::email($name, $value, $opts) !!}
</div>
@endmacro

@macrodef('password', $name, $opts = ['class' => 'form-control'], $addon = '')
<div class="input-group">
    <span class="input-group-addon">{!! $addon !!}</span>
    {!! Form::password($name, $opts) !!}
</div>
@endmacro

@macrodef('checkbox', $name, $text = '', $checked = false, $value = 'on')
@set('id', uniqid($name))
<div class="checkbox checkbox-primary">
    <input name="{!! $name !!}" id="{!! $id !!}" value="{{ $value }}" type="checkbox" @if( $checked ) checked="checked" @endif>
    <label for="{!! $id !!}">
        {!! $text !!}
    </label>
</div>
@unset('id')
@endmacro

@macrodef('text_display', $name, $value, $url = false)
<div class="form-group">
    <label for="company">{{ $name }}</label>
    <div>
        @if( $url )
            <a href="{{ $url }}">{{ $value }}</a>
        @else
            {{ $value }}
        @endif
    </div>
</div>
@endmacro

@macrodef('text_title', $name, $title, $required = false, $value = null)
<div class="form-group">
    <label for="name">
        {{ $title }}
        @if( $required )
            <span class="text-danger">*</span>
        @endif
    </label>
    {!! Form::text($name, $value, ['class' => 'form-control', 'placeholder' => 'Enter ' . strtolower($title)]) !!}
</div>
@endmacro

@macrodef('checkbox_title', $name, $title, $checked = false, $value = null, $label = '')
@set('id', uniqid($name))
<div class="form-group">
    <label for="name">
        {{ $title }}
    </label>
    <div class="checkbox checkbox-primary">
        <input name="{!! $name !!}" id="{!! $id !!}" value="{{ $value }}" type="checkbox" @if( $checked ) checked="checked" @endif>
        <label for="{!! $id !!}">
            {!! ($label != '') ? $label : $title  !!}
        </label>
    </div>
</div>
@unset('id')
@endmacro

@macrodef('textarea_title', $name, $title, $required = false, $value = null)
<div class="form-group">
    <label for="name">
        {{ $title }}
        @if( $required )
            <span class="text-danger">*</span>
        @endif
    </label>
    {!! Form::textarea($name, $value, ['class' => 'form-control', 'placeholder' => 'Enter ' . strtolower($title)]) !!}
</div>
@endmacro

@macrodef('number_title', $name, $title, $required = false, $value = null)
<div class="form-group">
    <label for="name">
        {{ $title }}
        @if( $required )
            <span class="text-danger">*</span>
        @endif
    </label>
    {!! Form::number($name, $value, ['class' => 'form-control', 'placeholder' => 'Enter ' . strtolower($title)]) !!}
</div>
@endmacro

@macrodef('currency_title', $name, $title, $required = false, $value = null)
<div class="form-group">
    <label for="name">
        {{ $title }}
        @if( $required )
            <span class="text-danger">*</span>
        @endif
    </label>
    <div class="input-group">
        <span class="input-group-addon">&pound;</span>
        {!! Form::number($name, $value, ['class' => 'form-control', 'step' => '0.01', 'placeholder' => 'Enter ' . strtolower($title)]) !!}
    </div>
</div>
@endmacro

@macrodef('decimal_title', $name, $title, $required = false, $value = null)
<div class="form-group">
    <label for="name">
        {{ $title }}
        @if( $required )
            <span class="text-danger">*</span>
        @endif
    </label>
    {!! Form::number($name, $value, ['class' => 'form-control', 'step' => 'any', 'placeholder' => 'Enter ' . strtolower($title)]) !!}
</div>
@endmacro

@macrodef('datetime_title', $name, $title, $required = false, $value = null)
<div class="form-group">
    <label for="name">
        {{ $title }}
        @if( $required )
            <span class="text-danger">*</span>
        @endif
    </label>
    <div class="row">
        <div class="col-sm-6">
            <div class="input-group">
                <input name="{{ $name }}[date]" value="{{ $value }}" type="text" class="form-control datepicker" placeholder="dd/mm/yyyy">
                <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
            </div><!-- input-group -->
        </div>
        <div class="col-sm-6">
            <div class="input-group clockpicker" data-placement="top" data-align="top" data-autoclose="true">
                <input name="{{ $name }}[time]" type="text" class="form-control" value="{{ $value }}">
                <span class="input-group-addon bg-custom b-0 text-white"> <span class="glyphicon glyphicon-time"></span> </span>
            </div>
        </div>
    </div>
</div>
@endmacro


@macrodef('date_title', $name, $title, $required = false, $value = null)
<div class="form-group">
    <label for="name">
        {{ $title }}
        @if( $required )
            <span class="text-danger">*</span>
        @endif
    </label>
    <div class="input-group">
        <input name="{{ $name }}" value="{{ $value }}" type="text" class="form-control datepicker" placeholder="dd/mm/yyyy">
        <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
    </div><!-- input-group -->
</div>
@endmacro


@macrodef('time_title', $name, $title, $required = false, $value = null)
<div class="form-group">
    <label for="name">
        {{ $title }}
        @if( $required )
            <span class="text-danger">*</span>
        @endif
    </label>
    <div class="input-group clockpicker" data-placement="top" data-align="top" data-autoclose="true">
        <input name="{{ $name }}" type="text" class="form-control" value="{{ $value }}">
        <span class="input-group-addon bg-custom b-0 text-white"> <span class="glyphicon glyphicon-time"></span> </span>
    </div>
</div>
@endmacro

@macrodef('colour_title', $name, $title, $required = false, $value = null)
<div class="form-group">
    <label for="name">
        {{ $title }}
        @if( $required )
            <span class="text-danger">*</span>
        @endif
    </label>
    <select name="{{ $name }}" class="colorselector">
        @foreach( Config::get('colours') as $colour => $title )
            <option value="{{ $colour }}" data-color="#{{ $colour }}" @if( $value == $colour ) selected="selected" @endif>{{ $title }}</option>
        @endforeach
    </select>
</div>
@endmacro

@macrodef('file_title', $name, $title, $required = false, $value = null)
<div class="form-group">
    <label for="name">
        {{ $title }}
        @if( $required )
            <span class="text-danger">*</span>
        @endif
    </label>
    <div class="form-group">
        <input type="file" name="{{ $name }}" class="filestyle" data-iconname="fa fa-cloud-upload">
    </div>
</div>
@endmacro

@macrodef('label_title', $title, $value)
<div class="form-group">
    <label for="name">
        {{ $title }}
    </label>
    <p>{!! $value !!}</p>
</div>
@endmacro

@macrodef('select_title', $name, $options, $title, $required = false, $value = null)
<div class="form-group">
    <label for="name">
        {{ $title }}
        @if( $required )
            <span class="text-danger">*</span>
        @endif
    </label>
    {!! Form::select($name, $options, $value, ['class' => 'form-control']) !!}
</div>
@endmacro

@macrodef('typeahead_title', $name, $url, $title, $required = false)
@set('input_id', uniqid('typeahead'))
<div class="form-group">
    <label for="name">
        {{ $title }}
        @if( $required )
            <span class="text-danger">*</span>
        @endif
    </label>
    {!! Form::hidden($name, null, ['id' => $input_id]) !!}
    {!! Form::text('', null, ['class' => 'form-control typeahead', 'placeholder' => 'Start typing ' . strtolower($title) . '...', 'autocomplete' => 'off', 'data-field' => '#'.$input_id, 'data-url' => $url]) !!}
</div>
@unset('input_id')
@endmacro

@macrodef('textarea_title', $name, $title, $required = false, $value = null)
<div class="form-group">
    <label for="name">
        {{ $title }}
        @if( $required )
            <span class="text-danger">*</span>
        @endif
    </label>
    {!! Form::textarea($name, $value, ['class' => 'form-control', 'placeholder' => 'Enter ' . strtolower($title)]) !!}
</div>
@endmacro

@macrodef('image_title', $name, $title, $required = false, $value = null)
<div class="form-group">
    <label for="name">
        {{ $title }}
        @if( $required )
            <span class="text-danger">*</span>
        @endif
    </label>
    <div class="form-group">
        <input type="file" name="{{ $name }}" class="filestyle" data-iconname="fa fa-cloud-upload">
    </div>
</div>
@endmacro

@macrodef('editable_text', $permission_group, $name, $title, $value = null, $url = false)
@set('editable', Permissions::has($permission_group, 'edit'))
<div class="form-group">
    <label for="name">{{ $title }}</label>
    @if( $editable )
        <div class="editable-container">
            <span class="editable" data-type="text" id="{{ $name }}" data-type="text" data-params='{"_token": "{{ csrf_token() }}"}' data-url="{{ $url }}" data-title="Enter {{ strtolower($title) }}">{!! FieldRenderer::longtext($value) !!}</span>
        </div>
    @else
        <p>{{ $value }}</p>
    @endif
</div>
@endmacro

@macrodef('editable_currency', $permission_group, $name, $title, $value = null, $url = false)
@set('editable', Permissions::has($permission_group, 'edit'))
<div class="form-group">
    <label for="name">{{ $title }}</label>
    @if( $editable )
        <div class="editable-container">
            <span class="editable" data-type="text" id="{{ $name }}" data-type="text" data-prepend="&pound;" data-value="{{ $value }}" data-params='{"_token": "{{ csrf_token() }}"}' data-url="{{ $url }}" data-title="Enter {{ strtolower($title) }}">&pound;{{ FieldRenderer::decimal($value) }}</span>
        </div>
    @else
        <p>&pound;{{ $value }}</p>
    @endif
</div>
@endmacro

@macrodef('editable_colour', $permission_group, $name, $title, $value = null, $url = false)
@set('editable', Permissions::has($permission_group, 'edit'))
<div class="form-group">
    <label for="name">{{ $title }}</label>
    @if( $editable )
        <div class="editable-container">
            <select name="{{ $name }}" class="colorselector" data-token="{{ csrf_token() }}" data-type="autosubmitsubmit" data-url="{{ $url }}">
                @foreach( Config::get('colours') as $colour => $colour_title )
                    <option value="{{ $colour }}" data-color="#{{ $colour }}" @if( $value == $colour ) selected="selected" @endif>{{ $colour_title }}</option>
                @endforeach
            </select>
        </div>
    @else
        <p><span class="btn-colorselector" style="background-color: #{{ $value }};"></span></p>
    @endif
</div>
@endmacro

@macrodef('editable_select', $permission_group, $name, $options, $title, $value = null, $url = false)
@set('editable', Permissions::has($permission_group, 'edit'))
<div class="form-group">
    <label for="name">{{ $title }}</label>
    @if( $editable )
        <div class="editable-container">
            <span class="editable"
                  data-type="select"
                  id="{{ $name }}"
                  @if( is_object($value) )
                   data-value="{{ $value->id }}"
                   @endif
                   data-options="{!! Settings::selectValues($options) !!}"
                   data-params='{"_token": "{{ csrf_token() }}"}' data-url="{{ $url }}" data-title="Enter {{ strtolower($title) }}">
                    @if( is_object($value) )
                    {!! FieldRenderer::display($value, 'None', $options) !!}
                    @elseif( is_array($options) && array_key_exists($value, $options))
                        {{ $options[$value] }}
                    @else
                    None
                    @endif
            </span>
        </div>
    @else
        <p>{!! FieldRenderer::display($value) !!}</p>
    @endif
</div>
@endmacro

@macrodef('editable_multiselect', $permission_group, $name, $options, $title, $value = null, $url = false)
@set('editable', Permissions::has($permission_group, 'edit'))
<div class="form-group">
    <label for="name">{{ $title }}</label>
    @if( $editable )
        <div class="editable-container">
            <span class="editable"
                  id="{{ $name }}"
               data-type="multiple"
               data-value="{!! Settings::multiSelectValues($value) !!}"
               data-options="{!! Settings::selectValues($options, 'value', true) !!}"
               data-params='{"_token": "{{ csrf_token() }}"}'
               data-url="{{ $url }}">
                {!! Settings::displaySelectValues($value) !!}
            </span>
        </div>
    @else
        <p>
            @if( is_array($value) )
                @foreach( $value as $item )
                    <span class="select-value">{{ $item->displayName() }}</span>
                @endforeach
            @else
                None
            @endif
        </p>
    @endif
</div>
@endmacro

@macrodef('editable_textarea', $permission_group, $name, $title, $value = null, $url = false)
@set('editable', Permissions::has($permission_group, 'edit'))
<div class="form-group">
    <label for="name">{{ $title }}</label>
    @if( $editable )
        <div class="editable-container">
            <span class="editable" id="{{ $name }}" data-inputclass="form-control" data-type="textArea" data-params='{"_token": "{{ csrf_token() }}"}' data-url="{{ $url }}" data-title="Enter username">{!! FieldRenderer::longtext($value) !!}</span>
        </div>
    @else
        <p>{!! $value !!}</p>
    @endif
</div>
@endmacro

@macrodef('editable_image', $permission_group, $image_url, $upload_route, $title = 'Upload an image')
@set('editable', Permissions::has($permission_group, 'edit'))
@set('modal_id', uniqid('image-modal'))
<div class="editable-image mb-b-10">
    <img src="{{ $image_url }}" />
    @if( $editable )
        <div class="options">
            <a href="#{{ $modal_id }}" data-animation="fadein" data-plugin="custommodal"
               data-overlaySpeed="200" data-overlayColor="#36404a"><i class="fa fa-pencil"></i> Edit picture</a>
        </div>

        @embed('fragments.page.modal', ['id' => $modal_id, 'route' => $upload_route, 'files' => true, 'title' => 'Upload Image', 'button' => 'Upload'])

            @section('content')

            <div class="form-group">
                <label class="control-label">{{ $title }}</label>
                <input type="file" name="media" class="filestyle" data-iconname="fa fa-cloud-upload">
            </div>

            @endsection

        @endembed
    @endif
</div>
@endmacro


@macrodef('editable_password', $editable, $name, $title, $url = false)
@set('editable', $editable)
<div class="form-group">
    <label for="name">{{ $title }}</label>
    @if( $editable )
        <div class="editable-container">
            <span href="#" class="editable" id="{{ $name }}" data-text="*******" data-type="password" data-params='{"_token": "{{ csrf_token() }}"}' data-url="{{ $url }}" data-title="Enter password">********</span>
        </div>
    @else
        <p>*******</p>
    @endif
</div>
@endmacro


@macrodef('editable_date', $permission_group, $name, $title, $value = null, $url = false)
@set('editable', Permissions::has($permission_group, 'edit'))
@set('display_value', FieldRenderer::formatDate($value))
<div class="form-group">
    <label for="name">{{ $title }}</label>
    @if( $editable )
        <div class="editable-container">
            <span href="#" class="editable"
               id="{{ $name }}"
               data-pk="1"
               data-type="date"
               data-params='{"_token": "{{ csrf_token() }}"}'
               data-url="{{ $url }}">{!! $display_value !!}</span>
        </div>
    @else
        <p>{!! $display_value !!}</p>
    @endif
</div>
@endmacro


@macrodef('editable_typeahead', $permission_group, $name, $title, $value, $lookup_url, $url)
@set('editable', Permissions::has($permission_group, 'edit'))
@set('display_value', FieldRenderer::display($value, ''))
<div class="form-group">
    <label for="name">{{ $title }}</label>
    @if( $editable )
        <div class="editable-container">
            <span class="editable"
               id="{{ $name }}"
               data-type="typeahead"
               data-source="{{ $lookup_url }}"
               data-params='{"_token": "{{ csrf_token() }}"}'
               data-url="{{ $url }}"
               data-title="{{ strtolower($title) }}">{{ $display_value }}</span>
        </div>
    @else
        <p>{!! $display_value !!}</p>
    @endif
</div>
@endmacro
