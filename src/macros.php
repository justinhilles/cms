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
	return Form::textarea($name, null, array('rows' => '100')).
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
			height: "400px"
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

Form::macro('buttons', function($route, $links = array(), $options = array(), $wrap = '<div id="actions" class="form-actions">%s</div>'){
	$links[] = link_to_route($route, 'Back', array(), array('class' => 'btn pull-right'));
	$links[] = Form::submit('Submit', array('class' => 'btn btn-primary pull-right'));
	return 	sprintf($wrap, implode('&nbsp;', $links));
});

Form::macro('tag', function( $route , $object = null, $files = false, $attributes = array()){
  if(!is_null($object)) {
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
