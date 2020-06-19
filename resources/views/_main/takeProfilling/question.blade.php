<div class="row">
	<div class="col-sm-12">
		<label>{{ $key+1 }}. {{ $val->question }}</label>
		<input type="hidden" name="questionHiddenCheck{{ $key+1 }}" class="questionHiddenCheck" data-qn="{{ $key+1 }}" value="question{{ $key+1 }}">
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