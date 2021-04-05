$('#forget').click(function(){
    $('#form-forget-password').show();
    $('#form-forget-password').css('transform', 'translateY(50px)');
    $('#form-forget-password').css('transition', 'all .5s');
})

$('.close').click(function(){
    $('#form-forget-password').hide();
})
