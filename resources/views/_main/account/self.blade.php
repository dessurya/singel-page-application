@extends('_layout.content.main')

@section('title')
  <title>User Area - Me</title>
@endsection

@section('css')
<style type="text/css">
</style>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>User Self Data</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('_js/gender2.js') }}"></script>
<script type="text/javascript">
	$( document ).ready(function() {
		var data = {};
		data['id'] = "{{ base64_encode(Auth::guard('user')->user()->id) }}";
		postData(data,"{{ route('account.form') }}");
	});
</script>
@endsection
