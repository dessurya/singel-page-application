<div class="x_panel">
	<form id="storeData">
		<div class="x_title">
			<h3 align="center">{{ $title }}</h3>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<div class="row">
				<input type="hidden" name="acckey" value="{{ $acckey }}">
				<input type="hidden" name="action" value="{{ $action }}">
				<input type="hidden" name="store" value="true">
				<input type="hidden" name="id" value="{{ !empty($var['Role']) ? $var['Role']['id'] : ''  }}">
				<div class="col-sm-12">
					<div class="form-group">
						Name <span class="name error"></span>
						<input 
							@if(in_array($action,['add','edit']))
							required
							@elseif($action=='view')
							readonly 
							@endif
							name="name" 
							type="text" 
							value="{{ !empty($var['Role']) ? $var['Role']['name'] : '' }}" 
							class="form-control">
					</div>
				</div>
				<div class="col-sm-12">
					@foreach($var['Access']['group_access'] as $group)
					<div class="col-sm-12">
						<hr>
						<span>{{ $group['name'] }}</span>
						@foreach($group['access_key'] as $access)
						<div class="row">
							<div class="col-sm-4">
								<span>{{ $access['name'] }} : </span>
							</div>
							<div class="col-sm-8">
								@foreach($access['option'] as $opt)
								<input 
									@if(
									isset($var['AccessMenu']['accKey'][$access['key']][$opt]) and
									$var['AccessMenu']['accKey'][$access['key']][$opt] == true) 
									checked @endif
									type="checkbox" name="{{ $access['key'].'^#^'.$opt }}" value="true"> {{ $opt }}&nbsp;&nbsp;&nbsp;
								@endforeach
							</div>
						</div>
						@endforeach
					</div>
					@endforeach
				</div>
			</div>
			@if(in_array($action,['add','edit']))
			<div style="float: right;">
				<button class="btn btn-success" type="submit">Save</button>
			</div>
			<div class="clearfix"></div>
			@endif
		</div>
	</form>
</div>