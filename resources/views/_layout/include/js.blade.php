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
	
	$(document).on('click', 'button#logout', function() {
		postData(null,"{{ route('auth.logout') }}");
		return false;
	});

	$(document).on('click', 'button#change_password', function() {
		var data = {};
		data['select'] = 'change_password';
		data['access'] = sessionStorage.getItem('accKey');
		postData(data,"{{ route('config.index') }}");
		return false;
	});

	function change_password(data) {
		$("#contentAccess").html('');
		$("#form").html(atob(data.callForm));
		return true;
	}

	function selfUpdate(data) {
		$("#contentAccess").html('');
		$("#form").html(atob(data.callForm));
		return true;
	}

	$( document ).ready(function() {
		$('#loading-page').hide();
		postData(null,"{{ route('config.menu') }}");
	});

	$(document).on('click', 'button.accKeyProcess', function(){
		$('button.accKeyProcess').removeClass('btn-info').addClass('btn-default');
		$(this).removeClass('btn-default').addClass('btn-info');
		var data = {};
		data['select'] = $(this).data('acckey');
		data['access'] = sessionStorage.getItem('accKey');
		postData(data,"{{ route('config.index') }}");
	});

	$(document).on('click', 'input.indexOfSearch', function(){
		var val = {};
		val['url'] = urlAction;
		val['pcndt'] = true;
		val['input'] = {};
		val['input']['data'] = {};
		val['input']['data']['acckey'] = 'indexOfSearch';
		val['input']['data']['action'] = 'indexOfSearch';
		val['input']['data']['storeData'] = {};
		val['input']['data']['storeData']['type'] = $(this).data('type');
		val['input']['data']['storeData']['val'] = $(this).val();

		sessionStorage.setItem("indexOfSearchTypeButton", $(this).data('type'));
		$('#modal-indexOfSearch').modal('show');
		postData(val,urlAction);
	});

	$(document).on('click', '#modal-indexOfSearch .modal-footer button', function(){
		var idSelect = getDataId(true, true);
		if(idSelect == false){ return false; }
		var val = {};
		val['url'] = urlAction;
		val['pcndt'] = true;
		val['input'] = {};
		val['input']['data'] = {};
		val['input']['data']['acckey'] = 'indexOfSearchProcess';
		val['input']['data']['action'] = 'indexOfSearchProcess';
		val['input']['data']['storeData'] = {};
		val['input']['data']['storeData']['type'] = sessionStorage.getItem("indexOfSearchTypeButton");;
		val['input']['data']['storeData']['id'] = idSelect;
		$('#modal-indexOfSearch').modal('hide');
		postData(val,urlAction);
	});

	function indexOfSearch(data) {
		$('#modal-indexOfSearch .modal-title').html(data.title);
		$('#modal-indexOfSearch .modal-body').html(atob(data.content));
		var configDtTab = JSON.parse(atob(data.config));
		var confDtTable = {};
		confDtTable['reBuild'] = false;
		confDtTable['ajaxUrl'] = "{{ route('config.tab.list') }}?dataUrl="+configDtTab.table.url;
		confDtTable['fieldSort'] = configDtTab.table.sortBy;
		confDtTable['ConfigColumns'] = configDtTab.table.config;
		confDtTable['dataTabOfId'] = data.dataTabOfId;
		confDtTable['dataPost'] = {};
		callDataTabless(confDtTable);
		return true;
	}

	function indexOfSearchResponse(data) {
		$('#form form#storeData input.indexOfSearchId.'+data.type).val(data.dataId);
		$('#form form#storeData input.indexOfSearch.'+data.type).val(data.valOfField);
		return true;
	}

	function setMenuOnSeasion(data) {
		sessionStorage.setItem("accKey", JSON.stringify(data.accKey));
		$("#menu").html(atob(data.menuOnSeasion));
		return true;
	}

	function callForm(data) {
		$("#form").html(atob(data.callForm));
		return true;
	}

	function takeProfilling(data) {
		$("#form").html(atob(data.callForm));
		sessionStorage.setItem("questionRender", JSON.stringify(data.question));
		$.each(data.question, function(i, item) {
			var renderHTML = '<div id="pageOfQuestion'+i+'" class="pageOfQuestion">'+atob(item)+'</div>';
			$("form#storeData .x_content #question").append(renderHTML);
			sessionStorage.setItem("questionPageCount", i);
		});

		sessionStorage.setItem("questionPage", 0);
		pageOfQuestionShow(0);
		return true;
	}

	function pageOfQuestionShow(page) {
		$("form#storeData .x_content #question .pageOfQuestion").hide();
		$("form#storeData .x_content #question #pageOfQuestion"+page).show();
		$("form#storeData .x_content #page label strong").html(page+1);
	}

	$(document).on('click', 'form#storeData .x_content span#questionNextPage', function(){
		var pageMax = sessionStorage.getItem("questionPageCount");
		var page = sessionStorage.getItem("questionPage");
		if(page == pageMax){
			var pndata = {};
			pndata['title'] = 'Info';
			pndata['type'] = 'Warning';
			pndata['text'] = 'This end of page!';
			pnotify(pndata); 
			return false;
		}
		page = parseInt(page)+1;
		sessionStorage.setItem("questionPage", page)
		pageOfQuestionShow(page);
		if(page == pageMax){
			$('form#storeData .x_content button').show();
			$('form#storeData .x_content span#questionPrevPage').show();
			$('form#storeData .x_content span#questionNextPage').hide();
		}
		if(page != pageMax){
			$('form#storeData .x_content button').hide();
			$('form#storeData .x_content span#questionPrevPage').hide();
		}
		return false;
	});

	$(document).on('click', 'form#storeData .x_content span#questionPrevPage', function(){
		var pageMax = sessionStorage.getItem("questionPageCount");
		var page = sessionStorage.getItem("questionPage");
		if(page == 0){
			var pndata = {};
			pndata['title'] = 'Info';
			pndata['type'] = 'Warning';
			pndata['text'] = 'This first page!';
			pnotify(pndata); 
			return false;
		}
		page = parseInt(page)-1;
		sessionStorage.setItem("questionPage", page)
		pageOfQuestionShow(page);
		if(page == 0){
			$('form#storeData .x_content span#questionNextPage').show();
			$('form#storeData .x_content span#questionPrevPage').hide();
		}
		if(page != pageMax){
			$('form#storeData .x_content button').hide();
		}
		return false;
	});

	function storeFormData(data) {
		var pndata = {};
		pndata['title'] = 'Info';
		pndata['type'] = 'Warning';
		pndata['text'] = data.info;
		pnotify(pndata); 
		if(data.reloadForm === undefined){
			$("#form").html('');
		}
		if(data.reloadTable === undefined){
			reloadDataTabless();
		}
	}

	function postData(data,url) {
		$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
		$.ajax({
			url: url,
			type: 'post',
			dataType: 'json',
			data: data,
			beforeSend: function() {
				$('#loading-page').show();
			},
			success: function(data) {
				responsePostData(data);
				$('#loading-page').hide();
			}
		});
	}

	function responsePostData(data){
		if (data.responseType == 'setMenuOnSeasion') { setMenuOnSeasion(data); }
		else if (data.responseType == 'bodyAccess') { bodyAccess(data); }
		else if (data.responseType == 'callForm') { callForm(data); }
		else if (data.responseType == 'storeFormData') { storeFormData(data); }
		else if (data.responseType == 'change_password') { change_password(data); }
		else if (data.responseType == 'selfUpdate') { selfUpdate(data); }
		else if (data.responseType == 'takeProfilling') { takeProfilling(data); }
		else if (data.responseType == 'indexOfSearch') { indexOfSearch(data); }
		else if (data.responseType == 'indexOfSearchResponse') { indexOfSearchResponse(data); }
		else if (data.responseType == 'notif') {
			var pndata = {};
			pndata['title'] = 'Info';
			pndata['type'] = 'Warning';
			pndata['text'] = data.info;
			pnotify(pndata);
		}
		else if (data.responseType == 'refresh') {
			var pndata = {};
			pndata['title'] = 'Info';
			pndata['type'] = 'Warning';
			pndata['text'] = data.info;
			pnotify(pndata);
			window.setTimeout(function() {
				location.reload();
			}, 1550);
		}
	}

	function bodyAccess(data) {
		$("#contentAccess").html(atob(data.content));
		$("#form").html('');
		var configDtTab = JSON.parse(atob(data.config));
		var confDtTable = {};
		confDtTable['reBuild'] = false;
		confDtTable['ajaxUrl'] = "{{ route('config.tab.list') }}?dataUrl="+configDtTab.table.url;
		confDtTable['fieldSort'] = configDtTab.table.sortBy;
		confDtTable['ConfigColumns'] = configDtTab.table.config;
		confDtTable['dataPost'] = {};
		sessionStorage.setItem("confDtTable", JSON.stringify(confDtTable));
		callDataTabless(confDtTable);
		return true;
	}

	function callDataTabless(setConf) {

		if(setConf.reBuild == true){
			datatable.destroy();
		}

		$.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings){
			return {
				"iStart": oSettings._iDisplayStart,
				"iEnd": oSettings.fnDisplayEnd(),
				"iLength": oSettings._iDisplayLength,
				"iTotal": oSettings.fnRecordsTotal(),
				"iFilteredTotal": oSettings.fnRecordsDisplay(),
				"iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
				"iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
			};
		};

		if(setConf.dataTabOfId === undefined){
			var dataTabOfId = '#table-data';
			datatable = $(dataTabOfId).DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					url: setConf.ajaxUrl,
					type: "POST",
					data: setConf.dataPost
				},
				aDataSort: [ setConf.fieldSort ],
				columns: setConf.ConfigColumns,
				initComplete: function () {
					var api = this.api();
					api.columns().every(function () {
						var column = this;
						if ($(column.footer()).hasClass('search')) {
							var input = $('<input type="text" class="search form-control input-sm" placeholder="Search '+$(column.footer()).text()+'" />');
							input.appendTo( $(column.footer()).empty() ).on('change', function (keypress) {
								if (column.search() !== this.value) {
					                        // var val = $.fn.dataTable.util.escapeRegex($(this).val());
					                        var val = this.value;
					                        column.search(val ? val : '', true, false).draw();
					                    }
					                });
						}
					});
				},
				rowCallback: function(row, data, iDisplayIndex) {
					$(row).attr('id', data.id);
				}
			});
		}else{
			var dataTabOfId = '#table-data1';
			datatableSerach = $(dataTabOfId).DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					url: setConf.ajaxUrl,
					type: "POST",
					data: setConf.dataPost
				},
				aDataSort: [ setConf.fieldSort ],
				columns: setConf.ConfigColumns,
				initComplete: function () {
					var api = this.api();
					api.columns().every(function () {
						var column = this;
						if ($(column.footer()).hasClass('search')) {
							var input = $('<input type="text" class="search form-control input-sm" placeholder="Search '+$(column.footer()).text()+'" />');
							input.appendTo( $(column.footer()).empty() ).on('change', function (keypress) {
								if (column.search() !== this.value) {
					                        // var val = $.fn.dataTable.util.escapeRegex($(this).val());
					                        var val = this.value;
					                        column.search(val ? val : '', true, false).draw();
					                    }
					                });
						}
					});
				},
				rowCallback: function(row, data, iDisplayIndex) {
					$(row).attr('id', data.id);
				}
			});
		}
	}

	function reloadDataTabless() {
		var confDtTable =JSON.parse(sessionStorage.getItem("confDtTable"));
		confDtTable['reBuild'] = true;
		if($('#table-data').length){
			callDataTabless(confDtTable);
		}
	}

	$(document).on('click', 'table#table-data tbody tr', function(){
		$(this).toggleClass('selected');
	});

	$(document).on('click', 'table#table-data1 tbody tr', function(){
		$(this).toggleClass('selected');
	});

	$(document).on('click', '#actionToolsGroupWrapper #dtSelectedAll', function(){
		$('table#table-data tbody tr').addClass('selected');
	});
	$(document).on('click', '#actionToolsGroupWrapper #dtUnselectedAll', function(){
		$('table#table-data tbody tr').removeClass('selected');
	});

	$(document).on('click', '#actionToolsGroupWrapper button', function(){
		var data = {};
		data['access'] = sessionStorage.getItem('accKey');
		data['action'] = $(this).data('action');
		data['select'] = $(this).data('select');
		data['acckey'] = $(this).data('key');
		data['conf'] = $(this).data('conf');
		actionToolsExcute(data);
	});

	$(document).on('submit', 'form#storeData', function(){
		var input  = {};
		input['access'] = sessionStorage.getItem('accKey');
		input['acckey'] = $("form#storeData input[name=acckey]").val();
		input['action'] = $("form#storeData input[name=action]").val();
		input['store'] = $("form#storeData input[name=store]").val();
		input['storeData'] = $(this).serializeArray();
		var data = {};
		data['title'] = 'Warning';
		data['type'] = 'info';
		data['text'] = 'Are You Sure Do This?';
		data['input'] = {};
		data['input']['data'] = input;
		pnotifyConfirm(data);
		return false;
	});

	function actionToolsExcute(data) {
		var id = getDataId(data.select, false);
		if(id == false){ return false; }
		var val = {};
		if(data.conf == true){
			data['id'] = id;
			val['title'] = 'Warning';
			val['type'] = 'info';
			val['text'] = 'Are You Sure Do '+data.action+' On Selected Data?';
			val['input'] = {};
			val['input']['url'] = urlAction;
			val['input']['data'] = {};
			val['input']['data'] = data;
			pnotifyConfirm(val);
		}else if(data.conf == false){
			val['url'] = urlAction;
			val['pcndt'] = true;
			val['input'] = {};
			val['input']['id'] = id;
			val['input']['data'] = data;
			postData(val,urlAction);
		}
		// if(action == 'form'){ $('.content-wrapper section.content .nav-tabs a[href="#Open"]').tab('show'); }
		// return false;
	}

	function getDataId(select, target){
		if(select == false){ return true; }
		var idData = "";
		if(target == false){
			$('table#table-data tbody tr.selected').each(function(){
				idData += $(this).attr('id')+'^';
			});
		}else{
			$('table#table-data1 tbody tr.selected').each(function(){
				idData += $(this).attr('id')+'^';
			});
		}
		var getLength = idData.length-1;
		idData = idData.substr(0, getLength);
		var pndata = {};
		if(idData === null || idData === '' || idData === undefined){
			pndata['title'] = 'Info';
			pndata['type'] = 'error';
			pndata['text'] = 'No Data Selected!';
			pnotify(pndata);
			return false;
		}else if( idData.indexOf('^') > -1){
			pndata['title'] = 'Info';
			pndata['type'] = 'error';
			pndata['text'] = 'You only can selected one data!';
			pnotify(pndata);
			return false;
		}
		return idData;
	}

	function pnotify(data) {
		new PNotify({
			title: data.title,
			text: data.text,
			type: data.type,
			delay: 3000
		});
	}

	function pnotifyConfirm(data) {
		new PNotify({
			after_open: function(ui){
				$(".true", ui.container).focus();
				$('#loading-page').show();
			},
			after_close: function(){
				$('#loading-page').hide();
			},
			title: data.title,
			text: data.text,
			type: data.type,
			delay: 3000,
			confirm: {
				confirm: true,
				buttons:[
				{ text: 'Yes', addClass: 'true btn-primary', removeClass: 'btn-default'},
				{ text: 'No', addClass: 'false'}
				]
			}
		}).get().on('pnotify.confirm', function(){
			postData(data,urlAction);
		});
	}
</script>