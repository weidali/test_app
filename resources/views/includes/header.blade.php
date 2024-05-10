{{-- <div class="navbar">
	<div class="navbar-inner">
		<a id="logo" href="/">Logo</a>
		<ul class="nav">
			<li><a href={{ url('stacks') }}>Stacks</a></li>
			<li><a href="/components">Components</a></li>
		</ul>
	</div>
 </div> --}}
<nav class="navbar navbar-expand-lg navbar-light bg-info">
	<div class="container-fluid">
	<a class="navbar-brand h1" href={{ route('stacks') }}>Stacks</a>
	<div class="justify-end ">
		<div class="col ">
		<a class="btn btn-sm btn-success" href={{ route('stacks') }}>Add Stacks</a>
		</div>
	</div>
	</div>
</nav>
 