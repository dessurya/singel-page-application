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

function indexOfSearch(data) {
    $('#modal-indexOfSearch .modal-title').html(data.title);
    $('#modal-indexOfSearch .modal-body').html(atob(data.content));
    var configDtTab = JSON.parse(atob(data.config));
    var confDtTable = {};
    confDtTable['reBuild'] = false;
    confDtTable['ajaxUrl'] = urlTabList+configDtTab.table.url;
    confDtTable['fieldSort'] = configDtTab.table.sortBy;
    confDtTable['ConfigColumns'] = configDtTab.table.config;
    confDtTable['dataTabOfId'] = data.dataTabOfId;
    confDtTable['dataPost'] = {};
    callDataTabless(confDtTable);
    return true;
}

function indexOfSearchResponse(data) {
    $.each(data.fillInput, function(key, row) {
        $('#form form#storeDataProfilling '+row.key).val(row.val);
    });
    return true;
}

function setMenuOnSeasion(data) {
    if (data.accKey !== null && data.menuOnSeasion !== null) {
        sessionStorage.setItem("accKey", JSON.stringify(data.accKey));
        $("#menu").html(atob(data.menuOnSeasion));
        $("#menu ul#myTab li:first").addClass('active');
        $("#menu #myTabContent .tab-pane:first").addClass('active');
        $("#menu #myTabContent .tab-pane:first").addClass('in');
    }
    return true;
}

function callForm(data) {
    $("#form").html(atob(data.callForm));
    if (data.reloadTable === true) { reloadDataTabless(); }
    return true;
}

function takeProfilling(data) {
    $("#form").html(atob(data.callForm));
    sessionStorage.setItem("questionRender", JSON.stringify(data.question));
    $.each(data.question, function(i, item) {
        var renderHTML = '<div id="pageOfQuestion'+i+'" class="pageOfQuestion">'+atob(item)+'</div>';
        $("form#storeData .x_content #question").append(renderHTML);
        sessionStorage.setItem("questionPageCount", parseInt(i));
    });

    sessionStorage.setItem("questionPage", 0);
    pageOfQuestionShow(0);
    $("#contentAccess").html('');
    return true;
}

function pageOfQuestionShow(page) {
    $("form#storeData .x_content #question .pageOfQuestion").hide();
    $("form#storeData .x_content #question #pageOfQuestion"+page).show();
    $("form#storeData .x_content #page label strong").html(page+1);
}

function storeFormData(data) {
    var pndata = {};
    // pndata['title'] = 'Info';
    // pndata['type'] = 'Warning';
    // pndata['text'] = data.info;
    // pnotify(pndata); 
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
    else if (data.responseType == 'generateExcelReport') { generateExcelReport(data); }
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
    }else if (data.responseType == 'appendTo') {
        $(data.target).append(atob(data.content));
    }
}

function generateExcelReport(data) {
    var link = document.createElement('a');
    link.download = data.config.name;
    link.href = 'data:application/vnd.ms-excel;base64,' + $.base64.encode(atob(data.config.view));
    link.click();
}

function bodyAccess(data) {
    $("#contentAccess").html(atob(data.content));
    $("#form").html('');
    var configDtTab = JSON.parse(atob(data.config));
    var confDtTable = {};
    confDtTable['reBuild'] = false;
    confDtTable['ajaxUrl'] = urlTabList+configDtTab.table.url;
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

function actionToolsExcute(data) {
    if(data.action == 'template'){ window.open(data.template, '_blank'); return false; }
    else if(data.action == 'upload'){ 
        sessionStorage.setItem('importBase64', null);
        sessionStorage.setItem('importConfig', JSON.stringify(data)); 
        $('input[type=file]').focus().trigger('click'); 
        return false; 
    }
    var id = getDataId({'select' : data.select, 'multiple' : data.multiple}, false);
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
    // return false;
}

function importExcute() {
    var data = JSON.parse(sessionStorage.getItem('importConfig'));
    data['base64'] = sessionStorage.getItem('importBase64');
    var val = {};
    val['title'] = 'Warning';
    val['type'] = 'info';
    val['text'] = 'Are You Sure Do Import Data?';
    val['input'] = {};
    val['input']['url'] = urlAction;
    val['input']['data'] = {};
    val['input']['data'] = data;
    pnotifyConfirm(val);
    $('input.import').val(null);
}

function getDataId(data, target){
    if(data.select == false){ return true; }
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
    if((idData === null || idData === '' || idData === undefined) && target == false){
        pndata['title'] = 'Info';
        pndata['type'] = 'error';
        pndata['text'] = 'No Data Selected!';
        pnotify(pndata);
        return false;
    }else if( data.multiple == false && idData.indexOf('^') > -1){
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

function questionHiddenCheck(elem) {
    var count = 0;
    var elemEach = 'form#storeData .x_content .questionHiddenCheck';
    if(elem != null){ 
        elem = parseInt(elem);
        elemEach = 'form#storeData .x_content #pageOfQuestion'+elem+' .questionHiddenCheck'; 
    }
    $(elemEach).each(function(){
        var checked = false;
        var inputName = $(this).val();
        var qn = $(this).data('qn');
        if($('form#storeData .x_content input[name='+inputName+']').is(':checked')) { checked = true; }
        
        if(checked == false){
            var pndata = {};
            pndata['title'] = 'Info';
            pndata['type'] = 'Warning';
            pndata['text'] = 'Please... answer question '+qn;
            pnotify(pndata);
            count = count+1;
        }
    });
    return count;
}