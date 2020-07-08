@if(!isset($access['actionBuild']) or $access['actionBuild'] != false)
<div style="position: relative; width: 100%; z-index: 10;">
	<div style="position: absolute; right: 0;">
		<div id="actionToolsGroupWrapper" class="btn-group">
			@if(isset($access['template']) and $access['template'] == true)
			<button type="button" 
			data-key="{{ $access['key'] }}" data-conf="false" data-action="template" data-select="false"
			data-template="{{ asset($access['config']['template']) }}" data-multiple="false"
			title="Template"
			class="btn btn-info"><i class="fa fa-cloud-download"></i></button>
			@endif
			@if(isset($access['upload']) and $access['upload'] == true)
			<button type="button" 
			data-key="{{ $access['key'] }}" data-conf="false" data-action="upload" data-select="false"
			data-template="" data-multiple="false"
			title="Upload"
			class="btn btn-info" for="upload"><i class="fa fa-cloud-upload"></i></button>
			<input class="import" type="file" data-type="profilling" accept=".xlsx" style="display: none;">
			@endif
			@if(isset($access['add']) and $access['add'] == true)
			<button type="button" 
			data-key="{{ $access['key'] }}" data-conf="false" data-action="add" data-select="false"
			data-template="" data-multiple="false"
			title="Add"
			class="btn btn-info"><i class="fa fa-plus"></i></button>
			@endif
			@if(isset($access['view']) and $access['view'] == true)
			<button type="button" 
			data-key="{{ $access['key'] }}" data-conf="false" data-action="view" data-select="true"
			data-template="" data-multiple="false"
			title="Open"
			class="btn btn-info"><i class="fa fa-folder-open"></i></button>
			@endif
			@if(isset($access['Activated/Inactivated']) and $access['Activated/Inactivated'] == true)
			<button type="button" 
			data-key="{{ $access['key'] }}" data-conf="true" data-action="Activated/Inactivated" data-select="true"
			data-template="" data-multiple="true"
			title="Activated/Inactivated"
			class="btn btn-info"><i class="fa fa-power-off"></i></button>
			@endif
			<span id="dtSelectedAll" class="btn btn-info" title="Selected All">
				<i class="fa fa-check-square-o"></i>
			</span>
			<span id="dtUnselectedAll" class="btn btn-info" title="Unselected All">
				<i class="fa fa-square"></i>
			</span>
		</div>
	</div>
</div>
@else
<div class="form-group">
	New Value <span class="new_value error"></span>
	<input  autocomplete="off" name="new_value" type="text" class="form-control" placeholder="New Value">
</div>
@endif
<div style="clear: both;"></div>
<div class="table-responsive">
	<table 
		@if(!isset($access['dataTabOfId'])) id="table-data" @else id="{{ $access['dataTabOfId'] }}" @endif
		class="table table-striped table-bordered no-footer" width="100%">
		<thead>
			<tr role="row">
				@foreach($access['config']['table']['config'] as $list)
				<th>{{ Str::title($list['name']) }}</th>
				@endforeach
			</tr>
		</thead>
		<tfoot class="">
			<tr role="row">
				@foreach($access['config']['table']['config'] as $list)
				@if($list['searchable'] == 'true')
				<th class="search">{{ Str::title($list['name']) }}</th>
				@else
				<th></th>
				@endif
				@endforeach
			</tr>
		</tfoot>
		<tbody></tbody>
	</table>
</div>