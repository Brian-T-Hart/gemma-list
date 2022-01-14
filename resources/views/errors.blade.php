@if ($errors->any())

	<div class="bg-danger notification is-danger">
		
			@foreach ($errors->all() as $error)

			<h6 class="m-0 p-2 text-white">{{ $error }}</h6>

			@endforeach
	
	</div>

@endif