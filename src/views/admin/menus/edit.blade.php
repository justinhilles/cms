@extends('admin::layouts.default')

@section('main')
    <h1>Edit Menus</h1>
    @include('cms::admin.menus.form', compact('menu'))
@stop