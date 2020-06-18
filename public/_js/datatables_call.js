var datatable;
$(document).on('click', 'table#table-data tbody tr', function(){
	$(this).toggleClass('selected');
});
$(document).on('click', 'table#table-data tbody tr td a.pict, #Open #storeData code a, #Open #galeri a.view', function(){
	if ($(this).hasClass('pict')) {
		$(this).parent().toggleClass('selected');
	}
	var pict = $(this).attr('href');
	var load = $('#loading-page img').attr('src');
	$('#loading-page img').attr('src', pict);
	$('#loading-page').addClass('pict').attr('title', 'Click any ware to close').show();
	$('#loading-page .cel').append('<span><div class="alert alert-info" style="width:400px; margin:10px auto 0;"><h4>Click any ware to close</h4></div><span>');
	$(document).on('click', '#loading-page', function(){
		$('#loading-page img').attr('src', load);
		$('#loading-page').removeClass('pict').attr('title', '').hide();
		$('#loading-page .cel span').remove();
	});
	return false;
});
$(document).on('click', '#action #DtTabFilter', function() {
	$('table#table-data tfoot').toggleClass('hide');
});
$(document).on('click', '#action #dtSelectedAll', function(){
	$('table#table-data tbody tr').addClass('selected');
});
$(document).on('click', '#action #dtUnselectedAll', function(){
	$('table#table-data tbody tr').removeClass('selected');
});
$(document).on('click', 'ul#action .tools, button#action.tools, #Open #galeri a.tools', function(){
	var action = $(this).data('action');
	var conf = $(this).data('conf');
	var val = $(this).data('val');
	var sel = $(this).data('sel');
	var mulsel = $(this).data('mulsel');
	var id = getDataId(sel, mulsel);
	if(id == false){ return false; }
	var data = {};
	if(conf == true){
		data['title'] = 'Warning';
		data['type'] = 'info';
		data['text'] = 'Are You Sure Do '+action+' On Selected Data?';
		data['exe'] = {};
		data['exe']['url'] = tools_ajaxUrl;
		data['exe']['pcndt'] = true;
		data['exe']['input'] = {};
		data['exe']['input']['id'] = id;
		data['exe']['input']['val'] = val;
		data['exe']['input']['action'] = action;
		pnotifyConfirm(data);
	}else if(conf == false){
		data['url'] = tools_ajaxUrl;
		data['pcndt'] = true;
		data['input'] = {};
		data['input']['id'] = id;
		data['input']['val'] = val;
		data['input']['action'] = action;
		excute(data);
	}
	if(action == 'form'){ $('.content-wrapper section.content .nav-tabs a[href="#Open"]').tab('show'); }
	return false;
});
$(document).on('submit', 'form#storeData', function(){
	var url   = $(this).attr('action');
	var input  = new FormData($(this)[0]);
	var data = {};
	data['title'] = 'Warning';
	data['type'] = 'info';
	data['text'] = 'Are You Sure Do This?';
	data['exe'] = {};
	data['exe']['url'] = url;
	data['exe']['input'] = input;
	pnotifyConfirm(data);
	return false;
});
$(document).on('click', '#Open button#add-galeri', function(){
	$('form#my-dropzone input[name=id]').val($(this).data('id'));
});
$(document).on('change', 'input[type = file]', function(e){
    var files = e.originalEvent.target.files;
    var size = 0;
    for (var i=0, len=files.length; i<len; i++){
        size = files[i].size;
    }
    // 5000000 - 5mb
    if(size > 5000000){
        $("input[type = file]").val('');
        var inf = {};
		inf['title'] = 'Error';
		inf['type'] = 'error';
		inf['text'] = 'File size exceeds 5MB!';
		pnotify(inf);
    }
});

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

	datatable = $('#table-data').DataTable({
		processing: true,
		serverSide: true,
		ajax: {
			url: setConf.ajaxUrl,
			type: "POST",
			data: setConf.dataPost
		},
		aaSorting: [ [setConf.fieldSort,'desc'] ],
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
			var info = this.fnPagingInfo();
			var page = info.iPage;
			var length = info.iLength;
			var index = page * length + (iDisplayIndex + 1);
			$('td:eq(0)', row).html(index);
			$(row).attr('id', data.id);
		}
	});
}

function getDataId(select, multiselect){
	if(select == false){ return true; }
	var idData = "";
	$('table#table-data tbody tr.selected').each(function(){
		idData += $(this).attr('id')+'^';
	});
	var getLength = idData.length-1;
	idData = idData.substr(0, getLength);
	var pndata = {};
	if(idData === null || idData === '' || idData === undefined){
		pndata['title'] = 'Info';
		pndata['type'] = 'error';
		pndata['text'] = 'No Data Selected!';
		pnotify(pndata);
		return false;
	}else if(multiselect == false && idData.indexOf('^') > -1){
		pndata['title'] = 'Info';
		pndata['type'] = 'error';
		pndata['text'] = 'Only can select one data!';
		pnotify(pndata);
		return false;
	}
	return idData;
}