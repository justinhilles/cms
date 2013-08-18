{{ Form::tag('admin.menus', (isset($menu) ? $menu : null), false, array('class' => 'form-horizontal')) }}
    <div class="control-group">
        {{ Form::label('title', 'Title:', array('class' => 'control-label')) }}
        <div class="controls">
            {{ Form::text('title') }}
        </div>
    </div>
    <div class="control-group">
        {{ Form::label('slug', 'Slug:', array('class' => 'control-label')) }}
        <div class="controls">
            {{ Form::text('slug') }}
        </div>
    </div>
    @if(isset($menu))
        <div class="control-group">
            {{ Form::label('pages', 'Pages:', array('class' => 'control-label')) }}
            <div class="controls">
                {{ Form::pages('pages[]', $menu->pages()->lists('id')) }}
            </div>
        </div>
    @endif
    <div class="control-group">
        <div class="controls">
            {{ Form::submit('Save', array('class' => 'btn btn-info')) }}
        </div>
    </div>
{{ Form::close() }}

@include('admin::global.errors', compact('errors'))