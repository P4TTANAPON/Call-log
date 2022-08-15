@if(isset($errors))
	@if(count($errors)>0)
	<div class="alert alert-danger">
		<strong>Whoops!</strong> There were some problems.<br><br>
		<ul>
		@foreach ($errors as $error)
			<li>{{ $error }}</li>
		@endforeach
		</ul>
	</div>
	@endif
@endif