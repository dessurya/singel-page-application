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
				@if(in_array($action,['revision/finalise']))
				<div class="col-sm-12">
					<div class="form-group">
						Notes <span class="note error"></span>
						<textarea
							@if(in_array($action,['view'])) readonly @endif
							@if($var['head']['status'] == 'Finalise') readonly @endif
							name="note" 
							class="form-control">{{ $var['head']['note'] }}</textarea> 
					</div>
				</div>
				@endif
				<div class="col-sm-12">
					<div class="" role="tabpanel" data-example-id="togglable-tabs">
						<ul id="myTab1" class="nav nav-tabs bar_tabs right" role="tablist">
							@if(in_array($action,['revision/finalise']))
							<li role="presentation"><a href="#tab_content11" id="result-tabb" role="tab" data-toggle="tab" aria-controls="result" aria-expanded="false">Profilling Result</a>
	                        </li>
							@endif
	                        <li role="presentation" class="active" class=""><a href="#tab_content22" role="tab" id="history-tabb" data-toggle="tab" aria-controls="history" aria-expanded="false">Profilling History</a>
	                        </li>
						</ul>
						<div id="myTabContent2" class="tab-content">
							@if(in_array($action,['revision/finalise']))
							<div role="tabpanel" class="tab-pane fade" id="tab_content11" aria-labelledby="result-tab">
								<div class="table-responsive">
									<table class="table table-striped table-bordered no-footer">
										<thead>
											<tr>
												<th>No</th>
												<th>Criteria</th>
												<th>Competencies</th>
												<th width="120px">Real Result</th>
												<th width="120px">Revision Result</th>
											</tr>
										</thead>
										<tbody>
											@for($loop = 1; $loop <= count($var['result']); $loop++)
											<input type="hidden"
												name="max_revision.{{ Str::slug($var['result'][($loop-1)]['criteria']['criteria'],'_') }}" 
												value="{{ $var['result'][($loop-1)]['criteria']['max_criteria_count'] }}">
											<tr>
												<td rowspan="{{ $var['result'][($loop-1)]['criteria']['max_competencies'] }}">
													{{ $loop }}
												</td>
												<td rowspan="{{ $var['result'][($loop-1)]['criteria']['max_competencies'] }}">
													{{ $var['result'][($loop-1)]['criteria']['criteria'] }}
												</td>
												@for($loopAgain = 1; $loopAgain <= count($var['result'][($loop-1)]['resault']); $loopAgain++)
													@if($loopAgain > 0) <tr> @endif
													<td>{{ $var['result'][($loop-1)]['resault'][$loopAgain-1]['competencies_name'] }}</td>
													<td>{{ $var['result'][($loop-1)]['resault'][$loopAgain-1]['real_resault'] }}</td>
													<td>
														<input type="number" min="0" class="form-control"
															@if($var['head']['status'] == 'Finalise') disabled @endif
															value="{{ $var['result'][($loop-1)]['resault'][$loopAgain-1]['revision_resault'] }}"
															name="value_revision.{{ Str::slug($var['result'][($loop-1)]['criteria']['criteria'],'_').'.'.Str::slug($var['result'][($loop-1)]['resault'][$loopAgain-1]['competencies_name'],'_') }}">
													</td>
													@if($loopAgain > 0) </tr> @endif
												@endfor
											</tr>
											@endfor
										</tbody>
									</table>
								</div>
							</div>
							@endif
							<div role="tabpanel" class="tab-pane fade active in" id="tab_content22" aria-labelledby="history-tab">
								<div class="table-responsive">
									<table class="table table-striped table-bordered no-footer">
										<thead>
											<tr>
												<th>No</th>
												<th>Question</th>
												<th>Answer</th>
												@if(in_array($action,['revision/finalise']))
												<th>Competencies</th>
												@endif
											</tr>
										</thead>
										<tbody>
											@for($loop = 1; $loop <= count($var['detl']); $loop++)
											<tr>
												<td>{{ $loop }}</td>
												<td>{{ $var['detl'][($loop-1)]->getQuestion->question }}</td>
												<td>{{ $var['detl'][($loop-1)]->getAnswer->answer }}</td>
												@if(in_array($action,['revision/finalise']))
												<td>{{ $var['detl'][($loop-1)]->getCompetencies->competencies }}</td>
												@endif
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
			@if(in_array($action,['revision/finalise']) and $var['head']['status'] != 'Finalise')
			<hr>
			<div style="float: right;">
				<input type="hidden" name="rf" value="Finalise">
				<button class="btn btn-success" type="submit">Finalise</button>
			</div>
			<div class="clearfix"></div>
			@endif
		</div>
	</form>
</div>