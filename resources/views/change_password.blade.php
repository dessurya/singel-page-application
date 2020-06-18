<div class="x_panel">
	<form id="storeData">
		<div class="x_title">
			<h3 align="center">Change Password</h3>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<div class="row">
				<input type="hidden" name="acckey" value="change_password">
				<input type="hidden" name="action" value="change_password">
				<input type="hidden" name="store" value="true">
				<div class="col-sm-6">
					<div class="form-group">
						Old Password <span class="old_password error"></span>
						<input 
							name="old_password" 
							type="password" 
							class="form-control">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						New Password <span class="new_password error"></span>
						<input 
							required
							name="new_password" 
							type="password" 
							class="form-control">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						Confirm Password <span class="cnfrm_password error"></span>
						<input 
							required
							name="cnfrm_password" 
							type="password" 
							class="form-control">
					</div>
				</div>
			</div>
			<div style="float: right;">
				<button class="btn btn-success" type="submit">Save</button>
			</div>
			<div class="clearfix"></div>
		</div>
	</form>
</div>