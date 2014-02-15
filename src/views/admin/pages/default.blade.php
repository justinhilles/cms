@extends('admin::layouts.default')

@section('stylesheets')
    @parent
    {{ stylesheet_link_tag('justinhilles/cms/assets/stylesheets/package') }}
@stop

@section('javascripts')
    @parent
    {{ javascript_include_tag('justinhilles/cms/assets/javascripts/package') }}
@stop

@section('main')
    <div class="row">
        @yield('content')
    </div>
@stop