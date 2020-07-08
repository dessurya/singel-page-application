$( document ).ready(function() {
	$('#loading-page').hide();
	postData(null,urlMenu);
	var data = {};
	data['select'] = 'change_password';
	postData(data,urlIndex);
});

$(document).on('click', 'button#logout', function() {
	postData(null,urlLogout);
	return false;
});

$(document).on('click', 'button#change_password', function() {
	var data = {};
	data['select'] = 'change_password';
	data['access'] = sessionStorage.getItem('accKey');
	postData(data,urlIndex);
	return false;
});

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
	data['multiple'] = $(this).data('multiple');
	data['acckey'] = $(this).data('key');
	data['conf'] = $(this).data('conf');
	data['template'] = $(this).data('template');
	actionToolsExcute(data);
});

$(document).on('change', 'input.import', function(e){
	var file = e.target.files[0];
	var reader = new FileReader();
	reader.readAsDataURL(file);
	reader.onloadend = function () {
		var b64 = reader.result.replace(/^data:.+;base64,/, '');
	    sessionStorage.setItem('importBase64', b64);
	    importExcute();
	};
});

$(document).on('submit', 'form#storeData', function(){
	var input  = {};
	input['access'] = sessionStorage.getItem('accKey');
	input['acckey'] = $("form#storeData input[name=acckey]").val();
	input['action'] = $("form#storeData input[name=action]").val();
	input['store'] = $("form#storeData input[name=store]").val();
	input['storeData'] = $(this).serializeArray();

	if (input['acckey'] == 'takeProfilling' && input['action'] == 'takeProfilling') {
		var checkRadio = questionHiddenCheck(null);
		if (checkRadio > 0) { return false; }
	}

	var data = {};
	data['title'] = 'Warning';
	data['type'] = 'info';
	data['text'] = 'Are You Sure Do This?';
	data['input'] = {};
	data['input']['data'] = input;
	pnotifyConfirm(data);
	return false;
});

$(document).on('submit', 'form#storeDataProfilling', function(){
	var detil = {};
	var count = 0;
	$('form#storeDataProfilling table tbody tr').each(function(){
		detil[$(this).attr('id')] = {
			'criteriaId' : $('form#storeDataProfilling input[name=criteriaId]').val(),
			'criteria' : $('form#storeDataProfilling input[name=criteria]').val(),
			'questionId' : $('form#storeDataProfilling input[name=questionId]').val(),
			'question' : $('form#storeDataProfilling input[name=question]').val(),
			'id' : $(this).find('input[name=id]').val(),
			'answerId' : $(this).find('input[name=answerId]').val(),
			'answer' : $(this).find('input[name=answer]').val(),
			'competenciesId' : $(this).find('input[name=competenciesId]').val(),
			'competencies' : $(this).find('input[name=competencies]').val()
		};
		count += 1;
	});
	if (count == 0) {
		pnotify({ 'title' : 'Info', 'text' : 'detil masih kosong ', 'type' : 'Warning' });
		return false;
	}
	var input  = {};
	input['access'] = sessionStorage.getItem('accKey');
	input['acckey'] = $("form#storeDataProfilling input[name=acckey]").val();
	input['action'] = $("form#storeDataProfilling input[name=action]").val();
	input['store'] = $("form#storeDataProfilling input[name=store]").val();
	input['storeData'] = detil;
	var data = {};
	data['title'] = 'Warning';
	data['type'] = 'info';
	data['text'] = 'Are You Sure Do This?';
	data['input'] = {};
	data['input']['data'] = input;
	pnotifyConfirm(data);
	return false;
});

$(document).on('click', 'button.accKeyProcess', function(){
	$('button.accKeyProcess').removeClass('btn-info').addClass('btn-default');
	$(this).removeClass('btn-default').addClass('btn-info');
	var data = {};
	data['select'] = $(this).data('acckey');
	data['access'] = sessionStorage.getItem('accKey');
	postData(data,urlIndex);
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
	sessionStorage.setItem("indexOfSearchTarget", $(this).data('target'));
	sessionStorage.setItem("indexOfSearchParent", $(this).data('parent'));
	$('#modal-indexOfSearch').modal('show');
	postData(val,urlAction);
});

$(document).on('click', '#addDetilsProfilling', function(){
	var val = {};
	val['input'] = {};
	val['input']['data'] = {};
	val['input']['data']['acckey'] = 'addDetilsProfilling';
	val['input']['data']['action'] = 'addDetilsProfilling';
	postData(val,urlAction);
});

$(document).on('click', '.removeDetilsProfilling', function(){
	var row = $(this).data('row');
	$(row).remove();
});

$(document).on('click', '#modal-indexOfSearch .modal-footer button', function(){
	var newValue = $('input[name=new_value]').val();
	var idSelect = getDataId({'select' : true, 'multiple' : false}, true);
	
	if (newValue.length > 0 && idSelect.length > 0) {
		pnotify({ 'title' : 'Info', 'type' : 'error', 'text' : 'you only can choose data or create new value' });
		return false;
	}else if(newValue.length == 0 && (idSelect.length == 0 || idSelect === null || idSelect === undefined || idSelect === "" || idSelect === false )){
		pnotify({ 'title' : 'Info', 'type' : 'error', 'text' : 'you must choose data or create new value' });
		return false;
	}
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
	val['input']['data']['storeData']['new'] = newValue;
	val['input']['data']['storeData']['target'] = sessionStorage.getItem("indexOfSearchTarget");
	val['input']['data']['storeData']['parent'] = sessionStorage.getItem("indexOfSearchParent");
	$('#modal-indexOfSearch').modal('hide');
	postData(val,urlAction);
});

$(document).on('click', 'form#storeData .x_content button#questionNextPage', function(){
	var pageMax = sessionStorage.getItem("questionPageCount");
	var page = sessionStorage.getItem("questionPage");
	var checkRadio = questionHiddenCheck(page);
	if (checkRadio > 0) { return false; }
	if(page == pageMax){
		var pndata = {};
		pndata['title'] = 'Info';
		pndata['type'] = 'Warning';
		pndata['text'] = 'This end of page!';
		pnotify(pndata);
		return false;
	}
	page = parseInt(page)+1;
	sessionStorage.setItem("questionPage", page);
	pageOfQuestionShow(page);
	$('form#storeData .x_content button#questionPrevPage').show();
	if(page == pageMax){
		$('form#storeData .x_content button').show();
		$('form#storeData .x_content button#questionNextPage').hide();
	}
	return false;
});

$(document).on('click', 'form#storeData .x_content button#questionPrevPage', function(){
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
	sessionStorage.setItem("questionPage", page);
	pageOfQuestionShow(page);
	$('form#storeData .x_content button').hide();
	$('form#storeData .x_content button#questionNextPage').show();
	$('form#storeData .x_content button#questionPrevPage').show();
	if(page == 0){
		$('form#storeData .x_content button#questionPrevPage').hide();
	}
	return false;
});