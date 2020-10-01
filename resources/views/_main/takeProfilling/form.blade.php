<div class="x_panel">
	<form id="storeData">
		<div class="x_title">
			<h3 align="center">Take Profilling</h3>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<div class="row">
				<div id="welcomeTextProfilling" class="text-center">
					<p>Please drink warm water before you take the test. Choose the statement that represents your natural</p>
					<p>Tendencies ... not what you wish ... or not what you are excepted by your current situation.</p>
					<button onclick="startprofilling()" class="btn btn-success">Start</button>
				</div>
				<input type="hidden" name="acckey" value="takeProfilling">
				<input type="hidden" name="action" value="takeProfilling">
				<input type="hidden" name="store" value="true">
				<div class="startProfilling">
					<div id="question"></div>
				</div>
			</div>
			<div id="page" class="startProfilling" style="float: left; padding-top: 10px;">
				<label>Page <strong></strong> of {{ $countPage }} || {{ $countQuestion }} Question</label>
			</div>
			<div class="startProfilling" style="float: right;">
				<button id="questionPrevPage" class="btn btn-default"  style="display: none;">Prev</button>
				<button id="questionNextPage" class="btn btn-default">Next</button>
				<button class="btn btn-success" style="display: none;" type="submit">Save</button>
			</div>
			<div class="clearfix"></div>
		</div>
	</form>
</div>