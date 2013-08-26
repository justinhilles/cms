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
            <div class="dd">
                <?php  $menu = Menu::handler($menu->slug, array('class' => 'dd-list'), 'ol');?>
                <?php foreach(Page::all() as $page):?>
                <?php  $menu->add($page->path, $page->title, null, array('class' => 'dd-handle'), array('class' => 'dd-item'));?>
                <?php endforeach;?>
                {{ $menu->render() }}
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