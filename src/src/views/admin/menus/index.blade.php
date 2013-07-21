@extends('admin::layouts.default')

@section('main')

<h1>All Menus</h1>

@if ($menus->count())
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
				<th>Slug</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($menus as $menu)
                <tr>
                    <td>{{{ $menu->title }}}</td>
					<td>{{{ $menu->slug }}}</td>
                    <td>{{ link_to_route('admin.menus.edit', 'Edit', array($menu->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('admin.menus.destroy', $menu->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $menus->links() }}
@else
    There are no menus
@endif
    <p>{{ link_to_route('admin.menus.create', 'Add new menu', array(), array('class' => 'btn btn-success')) }}</p>
@stop