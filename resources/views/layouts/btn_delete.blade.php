<a href="javascript:void(0)" class="btn btn-danger" onclick="confirmFormDelete('#form-del-{{ $controller }}-{{ $id }}')"><span class="glyphicon glyphicon-trash"></span> Delete</a>
<form id="form-del-{{ $controller }}-{{ $id }}" action="{{ url($url) }}" method="post">
	{!! csrf_field() !!}
	<input name="_method" type="hidden" value="delete"/>
</form>