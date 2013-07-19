{{ Form::tag('admin.pages', (isset($page) ? $page : null)) }}

    <div id="tree" class="span2">
        <ul class="nav nav-list">
            {{ NestedSetRenderer::create(Page::all()) }}
        </ul>
    </div>
    <div class="span7">

        <div class="control-group">
            {{ Form::label('title', 'Title:', array('class' => 'control-label')) }}
            <div class="controls">
                {{ Form::text('title', null, array('class' => 'input-xxlarge')) }}
            </div>
        </div>

        <div class="control-group">
            {{ Form::label('path', 'Path:', array('class' => 'control-label')) }}
            <div class="input-prepend">
                {{ Form::text('path', null, array('class' => 'input-xxlarge', 'placeholder' => 'Optional')) }}
            </div>
        </div>

        <div class="control-group">
            {{ Form::label('content', 'Content:', array('class' => 'control-label')) }}
            <div class="controls">
                {{ Form::ckeditor('content') }}
            </div>
        </div>

    </div>
    <div class="span2 well pull-right">

        @if(isset($page))
            <div class="control-group">
                <div class="controls">
                    {{ link_to($page->path, 'View Page') }}
                </div>
            </div>
        @endif


        <div class="control-group">
            {{ Form::label('slug', 'Slug:', array('class' => 'control-label')) }}
            <div class="controls">
                {{ Form::text('slug', null, array('class' => 'input-small', 'placeholder' => 'Optional')) }}
            </div>
        </div>

        <div class="control-group">
            {{ Form::label('layout', 'Layout:', array('class' => 'control-label')) }}
            <div class="controls">
                {{ Form::text('layout', null, array('class' => 'input-small', 'placeholder' => 'Optional')) }}
            </div>
        </div>

        <div class="control-group">
            {{ Form::label('view', 'View:', array('class' => 'control-label')) }}
            <div class="controls">
                {{ Form::views('view', null, array('class' => 'input-medium')) }}
            </div>
        </div>

        <div class="control-group">
            {{ Form::label('position', 'Position:', array('class' => 'control-label')) }}
            <div class="controls">
                {{ Form::position('position', isset($page) ? $page : null , array('class' => 'Page'), array('class' => 'input-medium')) }}
            </div>
        </div>

        <div class="control-group">
            {{ Form::label('forward_to', 'Forward To:', array('class' => 'control-label')) }}
            <div class="controls">
                {{ Form::select('forward_to', array('' => '--Select--') + Page::orderBy('lft')->lists('path', 'id'),  (isset($page) ? (int) $page->forward_to : array()), array('class' => 'input-medium')) }}
            </div>
        </div>
        
        <div class="control-group">
            {{ Form::label('status', 'Published?:', array('class' => 'control-label')) }}
            <div class="controls">
                {{ Form::publishable('status', 'published',  array(), array('class' => 'input-medium')) }}
            </div>
        </div>

        <div class="control-group">
            {{ Form::label('menu_id', 'Menu:', array('class' => 'control-label')) }}
            <div class="controls">
                {{ Form::collection('menu_id', Menu::all(), isset($page) ? $page->menus()->get() : array(), array('expand' => true)) }}
            </div>
        </div>

    </div>

    <div class="span12">
        <?php $action_links = array();?>
        <?php if(isset($page)):?>
            <?php $action_links[] = link_to_route('admin.pages.create','New', array(), array('class' => 'btn btn-success'));?>
        <?php endif;?>
        {{ Form::buttons('admin.pages.index', $action_links) }}
    </div>

{{ Form::close() }}

@include('cms::admin.global.errors', array('errors' => $errors))