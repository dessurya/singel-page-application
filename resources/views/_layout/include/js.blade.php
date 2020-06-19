<script type="text/javascript" src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendors/datatables.net-scroller/js/datatables.scroller.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('vendors/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendors/pnotify/pnotify.custom.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('_js/gender2.js') }}"></script>
<script type="text/javascript">
	var datatable;
	var datatableSerach;
	var urlAction = "{{ route('action') }}";
	var urlMenu = "{{ route('config.menu') }}";
	var urlIndex = "{{ route('config.index') }}";
	var urlTabList = "{{ route('config.tab.list') }}?dataUrl=";
	var urlLogout = "{{ route('auth.logout') }}";
</script>
<script type="text/javascript" src="{{ asset('_js/action.js') }}"></script>
<script type="text/javascript" src="{{ asset('_js/function.js') }}"></script>