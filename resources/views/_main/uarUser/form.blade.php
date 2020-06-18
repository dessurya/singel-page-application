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
				<input type="hidden" name="id" value="{{ !empty($var['User']) ? $var['User']['id'] : ''  }}">
				<div class="col-sm-6">
					<div class="form-group">
						Name <span class="name error"></span>
						<input 
							@if(in_array($action,['add','edit'])) required @elseif($action=='view') readonly @endif
							name="name" 
							type="text" 
							value="{{ !empty($var['User']) ? $var['User']['name'] : '' }}" 
							class="form-control">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						Project Code <span class="project_code error"></span>
						<input 
							@if(in_array($action,['add','edit'])) required @elseif($action=='view') readonly @endif
							name="project_code" 
							type="text" 
							value="{{ !empty($var['Detils']) ? $var['Detils']['project_code'] : '' }}" 
							class="form-control">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						Date Of Birth <span class="date_of_birth error"></span>
						<input 
							@if(in_array($action,['add','edit'])) required @elseif($action=='view') readonly @endif
							name="date_of_birth" 
							type="date" 
							value="{{ !empty($var['Detils']) ? $var['Detils']['date_of_birth'] : '' }}" 
							class="form-control">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						Project Name <span class="project_name error"></span>
						<input 
							@if(in_array($action,['add','edit'])) required @elseif($action=='view') readonly @endif
							name="project_name" 
							type="text" 
							value="{{ !empty($var['Detils']) ? $var['Detils']['project_name'] : '' }}" 
							class="form-control">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						Email <span class="email error"></span>
						<input 
							@if(in_array($action,['add','edit'])) required @elseif($action=='view') readonly @endif
							name="email" 
							type="email" 
							value="{{ !empty($var['User']) ? $var['User']['email'] : '' }}" 
							class="form-control">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						Group Co's <span class="group_cos error"></span>
						<input 
							@if(in_array($action,['add','edit'])) required @elseif($action=='view') readonly @endif
							name="group_cos" 
							type="text" 
							value="{{ !empty($var['Detils']) ? $var['Detils']['group_cos'] : '' }}" 
							class="form-control">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						Handphone <span class="phone error"></span>
						<input 
							@if(in_array($action,['add','edit'])) required @elseif($action=='view') readonly @endif
							name="phone" 
							type="text" 
							value="{{ !empty($var['Detils']) ? $var['Detils']['phone'] : '' }}" 
							class="form-control">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						Current Companies <span class="current_companies error"></span>
						<input 
							@if(in_array($action,['add','edit'])) required @elseif($action=='view') readonly @endif
							name="current_companies" 
							type="text" 
							value="{{ !empty($var['Detils']) ? $var['Detils']['current_companies'] : '' }}" 
							class="form-control">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						Gender <span class="phone error"></span><br>
						<div 
							@if($action=='view') style="pointer-events: none;" @endif
							id="gender2" class="btn-group" data-toggle="buttons">
							<label 
								class="btn 
								@if(!empty($var['Detils']) and $var['Detils']['gender'] == 'male') btn-primary
								@else btn-default
								@endif
							">
								<input 
									@if(!empty($var['Detils']) and $var['Detils']['gender'] == 'male') checked @endif
									type="radio" 
									name="gender" 
									value="male"> &nbsp; Male &nbsp;
							</label>
							<label 
								class="btn 
								@if(!empty($var['Detils']) and $var['Detils']['gender'] == 'female') btn-primary
								@else btn-default
								@endif
							">
								<input 
									@if(!empty($var['Detils']) and $var['Detils']['gender'] == 'female') checked @endif
									type="radio" 
									name="gender" 
									value="female"> Female
							</label>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						Industry <span class="industry error"></span>
						<select 
							@if(in_array($action,['add','edit'])) required @elseif($action=='view') readonly @endif
							name="industry"
							class="form-control">
							@foreach($var['Industry'] as $opt)
							<option @if(!empty($var['Detils']) and $var['Detils']['industry'] == $opt['value']) selected @endif
							value="{{ $opt['value'] }}">{{ $opt['value'] }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						Religion <span class="religion error"></span>
						<select 
							@if(in_array($action,['add','edit'])) required @elseif($action=='view') readonly @endif
							name="religion"
							class="form-control">
							@foreach($var['Religion'] as $opt)
							<option @if(!empty($var['Detils']) and $var['Detils']['religion'] == $opt['value']) selected @endif
							value="{{ $opt['value'] }}">{{ $opt['value'] }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						Work Title <span class="work_title error"></span>
						<input 
							@if(in_array($action,['add','edit'])) required @elseif($action=='view') readonly @endif
							name="work_title" 
							type="text" 
							value="{{ !empty($var) ? $var['Detils']['work_title'] : '' }}" 
							class="form-control">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						Marital Status <span class="marital_status error"></span>
						<select 
							@if(in_array($action,['add','edit'])) required @elseif($action=='view') readonly @endif
							name="marital_status"
							class="form-control">
							@foreach($var['Marital'] as $opt)
							<option @if(!empty($var['Detils']) and $var['Detils']['marital_status'] == $opt['value']) selected @endif
							value="{{ $opt['value'] }}">{{ $opt['value'] }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						Level <span class="level error"></span>
						<select 
							@if(in_array($action,['add','edit'])) required @elseif($action=='view') readonly @endif
							name="level"
							class="form-control">
							@foreach($var['Level'] as $opt)
							<option @if(!empty($var['Detils']) and $var['Detils']['level'] == $opt['value']) selected @endif
							value="{{ $opt['value'] }}">{{ $opt['value'] }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						Education <span class="education error"></span>
						<select 
							@if(in_array($action,['add','edit'])) required @elseif($action=='view') readonly @endif
							name="education"
							class="form-control">
							@foreach($var['Education'] as $opt)
							<option @if(!empty($var['Detils']) and $var['Detils']['education'] == $opt['value']) selected @endif
							value="{{ $opt['value'] }}">{{ $opt['value'] }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						Competencies <span class="competencies error"></span>
						<select 
							@if(in_array($action,['add','edit'])) required @elseif($action=='view') readonly @endif
							name="competencies"
							class="form-control">
							@foreach($var['Competencies'] as $opt)
							<option @if(!empty($var['Detils']) and $var['Detils']['competencies'] == $opt['value']) selected @endif
							value="{{ $opt['value'] }}">{{ $opt['value'] }}</option>
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