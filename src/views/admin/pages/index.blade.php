@extends('cms::admin.pages.default')

@section('content')
    <h1>All Pages</h1>
    @if ($pages->count())
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th></th>
                    <th>Title</th>
    				<th>Path</th>
                    <th>Slug</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($pages as $page)
                    <tr>
                        <td>{{ $page->isPublished() ? '<i class="icon-ok btn-success btn"></i>':'<i class="icon-remove btn-danger btn"></i>'  }}</td>
                        <td>{{ $page->getNestedTitle() }}</td>
    					<td>{{ link_to($page->path, $page->path) }}</td>
                        <td>{{ $page->slug }}</td>
                        <td>{{ link_to_route('admin.pages.edit', 'Edit', array($page->id), array('class' => 'btn btn-info')) }}</td>
                        <td>
                            {{ Form::open(array('method' => 'DELETE', 'route' => array('admin.pages.destroy', $page->id))) }}
                                {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                            {{ Form::close() }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        There are no pages
    @endif

    <p>{{ $pages->links() }}
    
    <p>{{ link_to_route('admin.pages.create', 'New', array(), array('class' => 'btn btn-success')) }}</p>
@stop