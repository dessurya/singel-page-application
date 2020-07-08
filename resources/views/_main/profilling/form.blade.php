<div class="x_panel">
	<form id="storeDataProfilling">
		<div class="x_title">
			<h3 align="center">{{ $title }}</h3>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<div class="row">
				<input type="hidden" name="acckey" value="{{ $acckey }}">
				<input type="hidden" name="action" value="{{ $action }}">
				<input type="hidden" name="store" value="true">
				<div class="col-sm-6">
					<div class="form-group">
						Criteria <span class="criteria error"></span>
						<input type="hidden" name="criteriaId" class="profillingCriteria indexOfSearchId" value="{{ !empty($var) ? $var['criteria_id'] : '' }}">
						<input 
							required
							autocomplete="off"
							name="criteria"
							type="text" 
							value="{{ !empty($var) ? $var['criteria'] : '' }}"
							data-type="profillingCriteria"
							data-target="input[name=criteria]-criteria|input[name=criteriaId]-id"
							data-parent=""
							class="profillingCriteria form-control indexOfSearch">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						Question <span class="question error"></span>
						<input type="hidden" name="questionId" class="profillingQuestion indexOfSearchId" value="{{ !empty($var) ? $var['question_id'] : '' }}">
						<input 
							required
							autocomplete="off"
							name="question"
							type="text" 
							value="{{ !empty($var) ? $var['question'] : '' }}"
							data-type="profillingQuestion"
							data-target="input[name=question]-question|input[name=questionId]-id"
							data-parent=""
							class="profillingQuestion form-control indexOfSearch">
					</div>
				</div>
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Answer</th>
							<th>Competencies</th>
							<th class="text-right">
								<span id="addDetilsProfilling" class="btn btn-success" title="add answer and competencies"><i class="fa fa-plus"></i></span>
							</th>
						</tr>
					</thead>
					<tbody>
						@if(!empty($var))
						@include('_main.profilling.detils', ['var' => $var])
						@endif
					</tbody>
				</table>
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