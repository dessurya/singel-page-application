$(document).on('click', '#gender2 label', function(){
    $('#gender2 label').removeClass('btn-primary').addClass('btn-default');
    $('#gender2 label').addClass('btn-default');
    $(this).removeClass('btn-default').addClass('btn-primary');
    $(this).addClass('btn-primary');
    var nameradio = $(this).find('input').attr('value');
    $('#gender2 label input').removeAttr('checked');
    $('#gender2 label input[value='+nameradio+']').attr('checked', true);
});