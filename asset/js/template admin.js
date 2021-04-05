
$('#checkbox-menu-toggle').click(function(){
    if($('#checkbox-menu-toggle').prop('checked') == true){
        $('#sidebar').css('transform', 'translateX(0)');
        $('.toggle').css('background-color', '#fff');
    }else {
        console.log('not checked');
        $('#sidebar').css('transform', 'translateX(-100%)');
        $('.toggle').css('background-color', '#ff4669ff');
    }

})
// $('#checkbox-menu-toggle').is(':checked');
