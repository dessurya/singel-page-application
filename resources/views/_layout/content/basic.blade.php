<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Halo</title>
        <link rel="icon" type="image/png" href="{{ asset('images/Logo.jpg') }}" />
        @include('_layout.include.css')
	</head>
	<body>
		<div id="content_render">
			<div id="heading">
				<div id="wrap">
					<div id="logo" class="cell">
						<img src="{{ asset('images/Profilling_Logo.jpg') }}" height="80px;">
					</div>
					<div id="welcome" class="cell">
						Hallo {{ Str::title(Auth::guard('user')->user()->name) }},<br>
						Welcome to Thinking-Map Assessment by paxcis.com
					</div>
					<div id="button" class="cell">
						<button id="change_password"  class="btn btn-success">Change Password</button>
						<button id="logout" class="btn btn-success">Logout</button>
					</div>
				</div>
			</div>
			<div id="content_body">
				<div id="menu"></div>
				<hr>
				<div id="form"></div>
				<div id="contentAccess"></div>
			</div>
		</div>

		<div class="modal fade" id="modal-indexOfSearch">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title"></h4>
					</div>
					<div class="modal-body">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-info pull-left">Process</button>
					</div>
				</div>
			</div>
		</div>

		<div id="loading-page">
            <div class="dis-table">
                <div class="row">
                    <div class="cel">
                        <img src="{{ asset('images/loading_1.gif') }}">
                    </div>
                </div>
            </div>
        </div>
        @include('_layout.include.js')
	</body>
</html>