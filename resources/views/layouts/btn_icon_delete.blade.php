<a href="javascript:void(0)" onclick="confirmFormDelete('#form-del-{{ $controller }}-{{ $id }}')"><span class="glyphicon glyphicon-trash" data-toggle="tooltip" title="Delete"></span></a>
<form id="form-del-{{ $controller }}-{{ $id }}" action="{{ $url }}" method="post">
	{!! csrf_field() !!}
	<input name="_method" type="hidden" value="delete"/>
</form>