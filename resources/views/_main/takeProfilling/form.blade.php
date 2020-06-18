<div class="x_panel">
	<form id="storeData">
		<div class="x_title">
			<h3 align="center">Take Profilling</h3>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<div class="row">
				<input type="hidden" name="acckey" value="takeProfilling">
				<input type="hidden" name="action" value="takeProfilling">
				<input type="hidden" name="store" value="true">
				<div id="question"></div>
			</div>
			<div id="page" style="float: left; padding-top: 10px;">
				<label>Page <strong></strong> of {{ $countPage }}</label>
			</div>
			<div style="float: right;">
				<span id="questionPrevPage" class="btn btn-default"  style="display: none;">Prev</span>
				<span id="questionNextPage" class="btn btn-default">Next</span>
				<button class="btn btn-success" style="display: none;" type="submit">Save</button>
			</div>
			<div class="clearfix"></div>
		</div>
	</form>
</div>