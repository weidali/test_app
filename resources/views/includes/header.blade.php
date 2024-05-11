<nav class="navbar navbar-expand-lg navbar-light">
	{{-- @if(session()->has('success'))
		<div class="alert alert-success">
			{{ session()->get('message') }}
		</div>
	@endif
	@if (session()->has('error'))
		{{ session('error') }}
	@endif --}}

	{{-- @if(count($errors) > 0 )
	<div class="alert alert-danger alert-dismissible fade show" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<ul class="p-0 m-0" style="list-style: none;">
			@foreach($errors->all() as $error)
			<li>{{$error}}</li>
			@endforeach
		</ul>
	</div>
	@endif --}}


	

	<div class="container-fluid">
		<a class="navbar-brand h1" href={{ route('stacks.index') }}>Stacks</a>
		<div class="justify-end ">
			@if (Route::is('stacks.index'))
			<div class="col ">
				<a class="btn btn-sm btn-success" href={{ route('stacks.create') }}>Add Stacks</a>
			</div>
			@endif
		</div>
	</div>
</nav>
<div class="col-sm-12">
	@if (isset($errors))
		@foreach($errors->all() as $error)
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			{{$error}}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
		@endforeach
	@endif

	@if (session('success'))
	<div class="alert alert-success alert-dismissible fade show" role="alert">
		{{ session('success') }}
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
	@endif
</div>


