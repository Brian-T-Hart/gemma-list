@if ($errors->any())

	<div class="notification is-danger">
		
			@foreach ($errors->all() as $error)

			<h6 class="text-danger">{{ $error }}</h6>

			@endforeach
	
	</div>

@endif