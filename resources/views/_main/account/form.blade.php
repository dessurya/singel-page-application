<form id="storeData" method="post" action="{{ route('account.form.store') }}">
	<div class="row">
		<input type="hidden" name="id" value="{{ $data['user']['id'] }}">
		<div class="col-sm-6">
			<div class="form-group">
				Name <span class="name error"></span>
				<input 
					required
					name="name" 
					type="text" 
					value="{{ $data != null ? $data['user']['name'] : '' }}" 
					class="form-control">
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				Project Code <span class="project_code error"></span>
				<input 
					required
					name="project_code" 
					type="text" 
					value="{{ $data != null ? $data['user_detil']['project_code'] : '' }}" 
					class="form-control">
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				Date Of Birth <span class="date_of_birth error"></span>
				<input 
					required
					name="date_of_birth" 
					type="date" 
					value="{{ $data != null ? $data['user_detil']['date_of_birth'] : '' }}" 
					class="form-control">
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				Project Name <span class="project_name error"></span>
				<input 
					required
					name="project_name" 
					type="text" 
					value="{{ $data != null ? $data['user_detil']['project_name'] : '' }}" 
					class="form-control">
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				Email <span class="email error"></span>
				<input 
					required
					name="email" 
					type="email" 
					value="{{ $data != null ? $data['user']['name'] : '' }}" 
					class="form-control">
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				Group Co's <span class="group_cos error"></span>
				<input 
					required
					name="group_cos" 
					type="text" 
					value="{{ $data != null ? $data['user_detil']['group_cos'] : '' }}" 
					class="form-control">
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				Handphone <span class="phone error"></span>
				<input 
					required
					name="phone" 
					type="text" 
					value="{{ $data != null ? $data['user_detil']['phone'] : '' }}" 
					class="form-control">
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				Current Companies <span class="current_companies error"></span>
				<input 
					required
					name="current_companies" 
					type="text" 
					value="{{ $data != null ? $data['user_detil']['current_companies'] : '' }}" 
					class="form-control">
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				Gender <span class="phone error"></span><br>
				<div id="gender2" class="btn-group" data-toggle="buttons">
					<label 
						class="btn 
						@if($data != null and $data['user_detil']['gender'] == 'male') btn-primary
						@else btn-default
						@endif
					">
						<input 
							@if($data != null and $data['user_detil']['gender'] == 'male') checked @endif
							type="radio" 
							name="gender" 
							value="male"> &nbsp; Male &nbsp;
					</label>
					<label 
						class="btn 
						@if($data != null and $data['user_detil']['gender'] == 'female') btn-primary
						@else btn-default
						@endif
					">
						<input 
							@if($data != null and $data['user_detil']['gender'] == 'female') checked @endif
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
				<input 
					required
					name="industry" 
					type="text" 
					value="{{ $data != null ? $data['user_detil']['industry'] : '' }}" 
					class="form-control">
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				Religion <span class="religion error"></span>
				<input 
					required
					name="religion" 
					type="text" 
					value="{{ $data != null ? $data['user_detil']['religion'] : '' }}" 
					class="form-control">
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				Work Title <span class="work_title error"></span>
				<input 
					required
					name="work_title" 
					type="text" 
					value="{{ $data != null ? $data['user_detil']['work_title'] : '' }}" 
					class="form-control">
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				Marital Status <span class="marital_status error"></span>
				<input 
					required
					name="marital_status" 
					type="text" 
					value="{{ $data != null ? $data['user_detil']['marital_status'] : '' }}" 
					class="form-control">
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				Level <span class="level error"></span>
				<input 
					required
					name="level" 
					type="text" 
					value="{{ $data != null ? $data['user_detil']['level'] : '' }}" 
					class="form-control">
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				Education <span class="education error"></span>
				<input 
					required
					name="education" 
					type="text" 
					value="{{ $data != null ? $data['user_detil']['education'] : '' }}" 
					class="form-control">
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				Competencies <span class="competencies error"></span>
				<input 
					required
					name="competencies" 
					type="text" 
					value="{{ $data != null ? $data['user_detil']['competencies'] : '' }}" 
					class="form-control">
			</div>
		</div>
	</div>
	<div style="float: right;">
		<button class="btn btn-success" type="submit">Save</button>
	</div>
	<div class="clearfix"></div>
</form>