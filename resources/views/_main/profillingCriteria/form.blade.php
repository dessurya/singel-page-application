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
				<input type="hidden" name="id" value="{{ !empty($var) ? $var['id'] : ''  }}">
				<div class="col-sm-6">
					<div class="form-group">
						Criteria <span class="criteria error"></span>
						<input 
							@if(in_array($action,['add','edit']))
							required
							@elseif($action=='view')
							readonly 
							@endif
							value="{{ !empty($var) ? $var['criteria'] : '' }}" 
							name="criteria" 
							type="text"
							class="form-control">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						Flag <span class="flag error"></span>
						<input 
							@if(in_array($action,['add','edit']))
							required
							@elseif($action=='view')
							readonly 
							@endif
							name="flag" 
							type="number"
							value="{{ !empty($var) ? $var['flag'] : '' }}" 
							class="form-control">
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
						Description <span class="description error"></span>
						<textarea 
							@if(in_array($action,['add','edit']))
							@elseif($action=='view')
							readonly 
							@endif
							name="description" 
							type="text"
							rows="5"
							class="form-control">{{ !empty($var) ? $var['description'] : '' }}</textarea>
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