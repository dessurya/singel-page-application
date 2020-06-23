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
				<input type="hidden" name="id" value="{{ !empty($var['Admin']) ? $var['Admin']['id'] : ''  }}">
				<div class="col-sm-12">
					<div class="form-group">
						Email <span class="email error"></span>
						<input 
							@if(in_array($action,['add','edit']))
							required
							@elseif($action=='view')
							readonly 
							@endif
							name="email" 
							type="email" 
							value="{{ !empty($var['Admin']) ? $var['Admin']['email'] : '' }}" 
							class="form-control">
					</div>
				</div>
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
							value="{{ !empty($var['Admin']) ? $var['Admin']['name'] : '' }}" 
							class="form-control">
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
						Role <span class="role error"></span>
						<select 
							@if(in_array($action,['add','edit'])) required @elseif($action=='view') readonly @endif
							name="role"
							class="form-control">
							@foreach($var['Role'] as $opt)
							<option @if(!empty($var['Admin']) and $var['Admin']['roll_id'] == $opt['id']) selected @endif
							value="{{ $opt['id'] }}">{{ $opt['name'] }}</option>
							@endforeach
						</select>
					</div>
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