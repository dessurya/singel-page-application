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
						Question <span class="question error"></span>
						<input type="hidden" name="questionId" class="profillingQuestion indexOfSearchId" value="{{ !empty($var) ? $var['question_id'] : '' }}">
						<input 
							required
							autocomplete="off"
							name="question"
							type="text" 
							value="{{ !empty($var) ? $var['question'] : '' }}"
							data-type="profillingQuestion"
							class="profillingQuestion form-control indexOfSearch">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						Answer <span class="answer error"></span>
						<input type="hidden" name="answerId" class="profillingAnswer indexOfSearchId" value="{{ !empty($var) ? $var['answer_id'] : '' }}">
						<input 
							required
							autocomplete="off"
							name="answer"
							type="text" 
							value="{{ !empty($var) ? $var['answer'] : '' }}"
							data-type="profillingAnswer"
							class="profillingAnswer form-control indexOfSearch">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						Competencies <span class="competencies error"></span>
						<input type="hidden" name="competenciesId" class="profillingCompetencies indexOfSearchId" value="{{ !empty($var) ? $var['competencies_id'] : '' }}">
						<input 
							required
							autocomplete="off"
							name="competencies"
							type="text" 
							value="{{ !empty($var) ? $var['competencies'] : '' }}"
							data-type="profillingCompetencies"
							class="profillingCompetencies form-control indexOfSearch">
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