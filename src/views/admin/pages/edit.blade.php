@extends('admin::layouts.default')

@section('main')
	<h1>Edit Page</h1>
	@include('cms::admin.pages.form', compact('page'))
@stop

