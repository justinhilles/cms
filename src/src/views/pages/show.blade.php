@extends(Config::get('cms::config.front.layout'))

@section('main')
	<div id="content" class="span12">
		<div class="row">
			@if (Session::has('message'))
				<div class="flash alert">
					<p>{{ Session::get('message') }}</p>
				</div>
			@endif
			<h1>{{ $page->title }}</h1>
			<p>{{ $page->content }}</p>
		</div>
	</div>
@stop
