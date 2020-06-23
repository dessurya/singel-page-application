<div class="x_panel">
	<form id="storeData">
		<div class="x_title">
			<h3 align="center">Your Import Resault</h3>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<div class="row">
				<div class="col-sm-12">
					<div class="" role="tabpanel" data-example-id="togglable-tabs">
						<ul id="myTab1" class="nav nav-tabs bar_tabs right" role="tablist">
							<li role="presentation" class="active"><a href="#tab_content11" id="success-tabb" role="tab" data-toggle="tab" aria-controls="success" aria-expanded="false">Success</a>
	                        </li>
	                        <li role="presentation" class=""><a href="#tab_content22" role="tab" id="error-tabb" data-toggle="tab" aria-controls="error" aria-expanded="false">Error</a>
	                        </li>
						</ul>
						<div id="myTabContent2" class="tab-content">
							<div role="tabpanel" class="tab-pane fade active in" id="tab_content11" aria-labelledby="success-tab">
								<div class="table-responsive">
									<table class="table table-striped table-bordered no-footer">
										<thead>
											<tr>
												<th>No</th>
												<th>Criteria</th>
												<th>Question</th>
												<th>Answer</th>
												<th>Competencies</th>
											</tr>
										</thead>
										<tbody>
											@for($loop = 1; $loop <= count($result['true']); $loop++)
											<tr>
												<td>{{ $loop }}</td>
												<td>{{ $result['true'][($loop-1)]['criteria'] }}</td>
												<td>{{ $result['true'][($loop-1)]['question'] }}</td>
												<td>{{ $result['true'][($loop-1)]['answer'] }}</td>
												<td>{{ $result['true'][($loop-1)]['competencies'] }}</td>
											</tr>
											@endfor
										</tbody>
									</table>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane fade" id="tab_content22" aria-labelledby="error-tab">
								<div class="table-responsive">
									<table class="table table-striped table-bordered no-footer">
										<thead>
											<tr>
												<th>No</th>
												<th>Criteria</th>
												<th>Question</th>
												<th>Answer</th>
												<th>Competencies</th>
											</tr>
										</thead>
										<tbody>
											@for($loop = 1; $loop <= count($result['false']); $loop++)
											<tr>
												<td>{{ $loop }}</td>
												<td>{{ $result['false'][($loop-1)]['criteria'] }}</td>
												<td>{{ $result['false'][($loop-1)]['question'] }}</td>
												<td>{{ $result['false'][($loop-1)]['answer'] }}</td>
												<td>{{ $result['false'][($loop-1)]['competencies'] }}</td>
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
		</div>
	</form>
</div>