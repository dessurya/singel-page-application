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
				<input type="hidden" name="id" value="{{ !empty($var['head']) ? $var['head']['id'] : ''  }}">
				<div class="col-sm-6">
					<div class="form-group">
						Name <span class="name error"></span>
						<input 
							readonly
							name="name" 
							type="text" 
							value="{{ !empty($var['head']) ? $var['head']['name'] : '' }}" 
							class="form-control">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						Email <span class="email error"></span>
						<input 
							readonly
							name="email" 
							type="text" 
							value="{{ !empty($var['head']) ? $var['head']['email'] : '' }}" 
							class="form-control">
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
						Notes <span class="note error"></span>
						<textarea
							@if(in_array($action,['view'])) readonly @endif
							name="note" 
							class="form-control">{{ $var['head']['note'] }}</textarea> 
					</div>
				</div>
				<div class="col-sm-12">
					<div class="" role="tabpanel" data-example-id="togglable-tabs">
						<ul id="myTab1" class="nav nav-tabs bar_tabs right" role="tablist">
							<li role="presentation" class="active"><a href="#tab_content11" id="result-tabb" role="tab" data-toggle="tab" aria-controls="result" aria-expanded="false">Profilling Result</a>
	                        </li>
	                        <li role="presentation" class=""><a href="#tab_content22" role="tab" id="history-tabb" data-toggle="tab" aria-controls="history" aria-expanded="false">Profilling History</a>
	                        </li>
						</ul>
						<div id="myTabContent2" class="tab-content">
							<div role="tabpanel" class="tab-pane fade active in" id="tab_content11" aria-labelledby="result-tab">
								<div class="table-responsive">
									<table class="table table-striped table-bordered no-footer">
										<thead>
											<tr>
												<th>No</th>
												<th>Competencies</th>
												<th>Result</th>
											</tr>
										</thead>
										<tbody>
											@for($loop = 1; $loop <= count($var['competencies']); $loop++)
											<tr>
												<td>{{ $loop }}</td>
												<td>{{ $var['competencies'][($loop-1)]['competencies'] }}</td>
												<td>{{ $var['competencies'][($loop-1)]['count'] }}</td>
											</tr>
											@endfor
										</tbody>
									</table>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane fade" id="tab_content22" aria-labelledby="history-tab">
								<div class="table-responsive">
									<table class="table table-striped table-bordered no-footer">
										<thead>
											<tr>
												<th>No</th>
												<th>Question</th>
												<th>Answer</th>
												<th>Competencies</th>
											</tr>
										</thead>
										<tbody>
											@for($loop = 1; $loop <= count($var['detl']); $loop++)
											<tr>
												<td>{{ $loop }}</td>
												<td>{{ $var['detl'][($loop-1)]->getQuestion->question }}</td>
												<td>{{ $var['detl'][($loop-1)]->getAnswer->answer }}</td>
												<td>{{ $var['detl'][($loop-1)]->getCompetencies->competencies }}</td>
											</tr>
											@endfor
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			@if(in_array($action,['revision/finalise']))
			<hr>
			<div style="float: left;">
				<div 
					id="gender2" class="btn-group" data-toggle="buttons">
					<label class="btn btn-default">
						<input 
							type="radio" 
							name="rf" 
							value="revision"> &nbsp; Revision &nbsp;
					</label>
					<label class="btn btn-primary">
						<input 
							checked
							type="radio" 
							name="rf" 
							value="finalise"> Finalise
					</label>
				</div>
			</div>
			<div style="float: right;">
				<button class="btn btn-success" type="submit">Save</button>
			</div>
			<div class="clearfix"></div>
			@endif
		</div>
	</form>
</div>