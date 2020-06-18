<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Halo</title>
        @include('_layout.include.css')
        <link rel="stylesheet" href="{{ asset('vendors/pnotify/pnotify.custom.min.css') }}">
	</head>
	<body>
		<div style="position: relative; width: 100%; height: 120px; display: table;">
			<div style="position: relative; display: table-row; width: 100%; height: 120px;">
				<div style="position: relative; display: table-cell; width: 10%; height: 120px; vertical-align: middle; text-align: center;">
					<img src="{{ asset('images/loading_1.gif') }}" height="80px;">
				</div>
				<div style="position: relative; display: table-cell; width: 80%; height: 120px; vertical-align: middle; text-align: center;">
					Welcome {{ Str::title(Auth::guard('user')->user()->name) }}<br>
					paxic.com Thinking-behaviour Profilling
				</div>
				<div style="position: relative; display: table-cell; width: 10%; height: 120px; vertical-align: middle; text-align: center;">
					<button id="change_password"  class="btn btn-success">Change Password</button>
					<button id="logout" class="btn btn-success">Logout</button>
				</div>
			</div>
		</div>
		<div style="position: relative; width: 80%; margin: 0 auto;">
			<div id="menu"></div>
			<hr>
			<div id="form"></div>
			<div id="contentAccess"></div>
		</div>

		<div class="modal fade" id="modal-indexOfSearch">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title"></h4>
					</div>
					<div class="modal-body">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-info pull-left">Select</button>
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