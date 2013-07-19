@extends('layouts.default')
@section('main')
    <div id="content" class="span12 push">
        <div class="row">
            <div class="span3">
    			@include('global.login');
            </div>
            <div class="span6 banner">
                {{ $page->content }}            
            </div>
            <div class="span3">
                <div id="right" class="tabs right">
                    <ul>
                        <li><a href="#events"><i class="icon-calendar"></i>Events</a></li>
                        <li><a href="#news"><i class="icon-bell"></i>News</a></li>
                    </ul>
                    <div id="events">
                        <div class="white pad">
                            @include('events.widget')
                        </div>
                    </div>
                    <div id="news">
                        <div class="white pad">
                            @include('articles.widget')                       
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('global.sub')
@stop
