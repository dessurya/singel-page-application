<div class="row">
	<div class="col-sm-12">
		<label>{{ $key+1 }}. {{ $val->question }}</label>
	</div>
	@foreach($val->getChoice as $choice)
		@if($choice->status == 'Y')
			<div class="col-sm-6">
				<div class="radio">
					<label>
						<input type="radio" name="question{{ $key+1 }}" value="{{ $choice->id }}">&nbsp;{{ $choice->getAnswer->answer }}
					</label>
				</div>
			</div>
		@endif
	@endforeach
	<div class="clearfix"></div>
</div>