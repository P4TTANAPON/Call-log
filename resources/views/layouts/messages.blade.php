@if (Session::has('message'))
<div class="flash alert alert-info">
	<p>{{ Session::get('message') }}</p>
</div>
@endif
@if (isset($message))
	@if($message!='')
	<div class="flash alert alert-info">
		<p>{{ $message }}</p>
	</div>
	@endif
@endif