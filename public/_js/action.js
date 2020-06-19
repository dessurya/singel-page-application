$( document ).ready(function() {
	$('#loading-page').hide();
	postData(null,urlMenu);
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

$(document).on('click', 'form#storeData .x_content span#questionNextPage', function(){
	var pageMax = sessionStorage.getItem("questionPageCount");
	var page = sessionStorage.getItem("questionPage");
	var checkRadio = questionHiddenCheck('#pageOfQuestion'+page);
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