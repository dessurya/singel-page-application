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
				<div class="col-sm-12">
					<div class="form-group">
						Competencies <span class="competencies error"></span>
						<input 
							@if(in_array($action,['add','edit']))
							required
							@elseif($action=='view')
							readonly 
							@endif
							name="competencies" 
							type="text" 
							value="{{ !empty($var) ? $var['competencies'] : '' }}" 
							class="form-control">
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