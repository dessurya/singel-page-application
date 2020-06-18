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
							name="criteria" 
							type="text" 
							value="{{ !empty($var) ? $var['criteria'] : '' }}" 
							class="form-control">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						Sort <span class="sort error"></span>
						<input 
							@if(in_array($action,['add','edit']))
							required
							@elseif($action=='view')
							readonly 
							@endif
							name="sort" 
							type="number" 
							value="{{ !empty($var) ? $var['sort'] : '' }}" 
							class="form-control">
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
						Question <span class="question error"></span>
						<textarea 
							@if(in_array($action,['add','edit']))
							required
							@elseif($action=='view')
							readonly 
							@endif
							name="question" 
							type="text"
							class="form-control">{{ !empty($var) ? $var['question'] : '' }}</textarea>
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