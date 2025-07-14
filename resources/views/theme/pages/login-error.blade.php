@extends('theme.main')

@section('pagecss')
<style>
	.form-title {
		margin-bottom: 10px;
		color: #3c5d90;
	}
	.primary-text-color {
		color: #3c5d90;
	}
	.primary-button-color {
		background-color: #3c5d90 !important;
	}
</style>
@endsection

@section('content')
	
	<section>
		<div class="custom-alert" id="custom-alert">
			<div class="row justify-content-center">
				<div class="card col-4 shadow" style="margin-bottom: 100px;">
					<div class="card-header bg-white border-0">
						<h5 class="text-uppercase form-title pt-2 pb-0 mb-0 text-danger">Login Error</h5>
					</div>
					<div class="card-body">
						<p class="mb-0">Incorrect username or password. Please try again.</p>
					</div>
					<div class="card-footer bg-white border-0 py-4">
						<button type="button" href="{{ route('home') }}" id="exit-custom-alert" class="btn primary-button-color text-white w-100"><small>Login Again</small></button>
					</div>
				</div>	
			</div>
		</div>
	</section>
	
@endsection

@section('pagejs')
<script>
	$('#exit-custom-alert').on('click', function() {
		alert()
		$('#newLoginModalOpen').click();
	});
</script>
@endsection