$(document).ready(function(){
    $('.toggle-block-link').each(function(){
        var blockId = $(this).attr('id').substr(7);
        $('#' + blockId).hide();
    });
    $('.toggle-block-link').click(function(){
        var blockId = $(this).attr('id').substr(7);
        $('#' + blockId).toggle();
    });
});