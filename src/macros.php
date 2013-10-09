<?php

Form::macro('pages', function($name, $pages, $format = "<label class=\"checkbox\">%s%s</label>") {

	$checks = array();
    foreach(Page::orderBy('lft')->get() as $page) {
    	$checked = in_array($page->id, $pages);
    	$checks[] = sprintf($format, Form::checkbox('pages[]', $page->id, $checked), Form::label('pages', $page->getNestedTitle()));
    }

    return "<div id=\"#$name\">".implode("\n", $checks)."</div>";
});

Form::macro('ckeditor', function($name){
	return Form::textarea($name, null, array('rows' => '80')).
	'<script src="//cdnjs.cloudflare.com/ajax/libs/ckeditor/4.0.1/ckeditor.js"></script>'.
	'<script src="/vendor/ckfinder/ckfinder.js"></script>'.
	'<script type="text/javascript">
		CKEDITOR.replace(\''.$name.'\', {
			filebrowserBrowseUrl : 		"/vendor/ckfinder/ckfinder.html",
			filebrowserImageBrowseUrl : "/vendor/ckfinder/ckfinder.html?type=Images",
			filebrowserFlashBrowseUrl : "/vendor/ckfinder/ckfinder.html?type=Flash",
			filebrowserUploadUrl : 		"/vendor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files",
			filebrowserImageUploadUrl : "/vendor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images",
			filebrowserFlashUploadUrl : "/vendor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash",
			height: "280px"
		});
	</script>';
});

Form::macro('views', function($name, $value = null, $options = array()) {
	$views = Config::get('cms::config.views');
	return Form::select($name, $views, $value, $options);
});

Form::macro('nested', function($name, $object = null, $options = array(), $attributes = array()) {

	$default = array(
		'key_method' 		=> 'getNestedTitle', 
		'value' 			=> 'id', 
		'add_empty' 		=> '--Select--',
		'class' 			=> null,
		'methods' 			=>  array(
			'' 				=> '--Select Position--', 
			'makeChildOf' 	=> 'Make Child Of',
			'moveToLeftOf' 	=> 'Move Left Of',
			'moveToRightOf' => 'Move Right Of', 
		)
	);

	$options = array_merge($default, $options);

	extract($options);

	$class = !is_null($object) ? get_class($object) : $options['class'];

	if(!is_null($class)) {

		$nodes = $class::orderby('lft', 'asc')->get();

		$choices = array();

		if($options['add_empty']) {
			$choices = array('' => '--Select Node--');
		}
		
		foreach($nodes as $node) {
			$choices[$node->$value] = $node->$key_method();
		}

		$default_node = $default_method = null;

		if(empty($object)) {
			if($root = $class::roots()->first()) {
				$default_node = array($root->id);
				$default_method = array('makeChildOf');
			}
		}

	    $widgets[] = Form::select($name.'[node_id]', $choices, $default_node, $attributes);

		$widgets[] = Form::select($name.'[method]', $options['methods'], $default_method, $attributes);

		return implode("<br />", $widgets);		
	}

	return 'Nodes Not Available';

});

Form::macro('position', function($name, $object = null, $options = array(), $attributes = array()) {
	$default = array('class' => null);

	$options = array_merge($default, $options);

	$class = !is_null($object) ? get_class($object) : $options['class'];

	$is_root = (boolean) (!is_null($object) AND $object->isRoot());

    if( (!is_null($class) AND !is_null($class::roots()))) {
        return Form::nested('position', $object, array('class' => 'Page'), $attributes);
    } else {
     	return 'Not Available';
    }
});

Form::macro('date', function($name, $options = array()){
	return  Form::text($name, null, array('id' => $name.'_date')).
	sprintf(' <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
			<script type="text/javascript" src="//raw.github.com/timrwood/moment/develop/min/moment.min.js"></script>
			<script type="text/javascript">jQuery(function(){jQuery( "#%s_date" ).datepicker({ dateFormat: "yy-mm-dd" })});</script>', $name);
});

Form::macro('buttons', function($route, $links = array(), $options = array(), $wrap = '<div id="actions">%s</div>'){
	$links[] = link_to_route($route, 'Back', array(), array('class' => 'btn pull-right'));
	$links[] = Form::submit('Save', array('class' => 'btn btn-primary pull-right'));
	return 	sprintf($wrap, implode('&nbsp;', $links));
});

Form::macro('tag', function( $route , $params = array(), $files = false, $attributes = array()) {

  if(isset($params['page']) AND is_object($params['page'])) {

  	$object = $params['page'];
  	
  	$default_attributes = array('method' => 'PUT', 'route' => array($route.'.update', $object->id), 'files' => $files);
  	
  	return Form::model($object, array_merge($default_attributes, $attributes));
  } else {

  	$default_attributes = array('route' => $route.'.store', 'files' => $files);
  	
  	return Form::open(array_merge($default_attributes, $attributes));
  }
});

Form::macro('collection', function($name, Illuminate\Database\Eloquent\Collection $collection, $values = null, $options = array()) {

	$default = array('key' => 'title', 'value' => 'id', 'expand' => false, 'add_empty' => '--Select--');
	
	$options = array_merge($default, $options);

	$choices = array();

	if($options['add_empty'] && !$options['expand']) {
		$choices[''] = $options['add_empty'];
	}

	if($values instanceof Illuminate\Database\Eloquent\Collection) {
		$values = $values->lists($options['value']);
	}

	$choices = (array) $choices + $collection->lists($options['key'], $options['value']);

	if($options['expand']) {
		return Form::checkboxes($name, $values, $choices);
	} else {
		return Form::select($name, $choices, $values, $options);
	}
});

Form::macro('checkboxes', function($name, array $values = array(), $choices = array(),  $format = "<label class=\"checkbox\">%s%s</label>") {
	$checks = array();

	if(count($choices)) {
	    foreach($choices as $value => $label) {
	    	$checks[] = sprintf($format, Form::checkbox($name.'[]', $value, in_array($value, (array) $values)), Form::label($name.'[]', $label));
	    }
	}

    return "<div id=\"#$name\">".implode("\n", $checks)."</div>";
});

Form::macro('publishable', function($name, $value = 'published', $options = array(), $attributes = array()) {
	
	$default = array('values' => array('' => '-- Select --', 'published' => 'Published', 'draft' => 'Draft', 'unpublished' => 'Unpublished'));
	
	$options = array_merge($default, (array) $options);
	
	return Form::select($name, (array) $options['values'], $value, $attributes);
});

Form::macro('nestable', function($name, $params){

	if(isset($params['menu'])) {
		$menu = $params['menu'];
		$current_nodes = json_decode($menu->nodes, true);
	}

	$pages = json_decode(Page::all()->toJson(), true);
		
		$html = '<div class="span12"><div class="row">';
		if(isset($current_nodes)){
			$html .= '<div class="span6">'.NestableRenderer::create($name, $current_nodes).'</div>';
		}
        $html .= '<div class="span6">'.NestableRenderer::create('pages', $pages).'</div>';
        $html .= '</div></div>';
		$html .= <<<HTML
<div class="edit">
	<button id="button" class="btn" type="button">Add Custom Link</button>
</div>
HTML;
		$html .= Form::hidden($name);
        $html .= <<<HTML
<script>
	$(function(){
		
		function update(e){
			var list   = e.length ? e : $(e.target);
			var nodes  = JSON.stringify(list.nestable('serialise'));
			$('[name="{$name}"]').val(nodes);
		}

		function link(url, text) {
			return $('<li />').attr({
				'class': 'dd-item', 
				'data-path': url, 
				'data-title': text
			}).html($('<a />').attr({'class': 'dd-handle', href: url}).html(text));
		}

		function create_modal(path, title) {
			var m = $('<div class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h3 id="myModalLabel">Link</h3></div><div class="modal-body"><input id="url" type="text" placeholder="http://" /><input id="text" type="text" placeholder="Text" /><div class="modal-footer"><button class="btn" data-dismiss="modal" aria-hidden="true">Close</button><button class="btn btn-primary">Save</button></div>');

			if(path !== undefined) {
				m.find('#url').val(path);
			}

			if(title !== undefined) {
				m.find('#text').val(title);
			}

			return m;
		}

		var nodes = $('#{$name}').nestable().on('change', update);
		var pages = $('#pages').nestable();

		$('#button').click(function(e){

			var add = create_modal();

			add.find('.btn-primary').click(function(){
				var url = add.find('#url').val();
				var text = add.find('#text').val();
				nodes.find('.dd-list').append(link(url, text));
				add.modal('hide');
				nodes.trigger('change');
				add.remove();
			});

			add.modal();

			return false;
		});

		$('.dd-item').each(function(){
			$(this).prepend($('<button class="edit" type="button"><i class="icon-pencil"></i></button>'));
			$(this).prepend($('<button class="delete" type="button"><i class="icon-remove"></i></button>'));
		});

		$('.dd-item button.edit').click(function(){
			var handle = $(this).parent();
			var data = handle.data();
			var edit = create_modal(handle.data('path'), handle.data('title'));

			edit.find('.btn-primary').click(function(){
				handle.data('title', edit.find('#text').val());
				handle.data('path', edit.find('#url').val());
				edit.modal('hide');
				nodes.trigger('change');
				edit.remove();
			});

			edit.modal();
		});

		$('.dd-item button.delete').click(function(e){
			$(this).parent().slideUp().remove();
			nodes.trigger('change');
		});
	});
</script>
HTML;
        return sprintf('<div class="nestable row">%s</div>', $html);
});
