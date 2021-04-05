console.log('ok');

var thumb = document.getElementsByClassName('thumb');
var image = document.getElementsByClassName('main-image')[0];
var ajax = window.location.origin + '/toko-sepatu/asset/ajax/image.php';
const menuToggle = document.querySelector('.menu-toggle');
const nav = document.querySelector('.top-nav ul');

var heightMainImage = 0;
if($('body').width() < 576){
    heightMainImage = $('body').width();
    $('.main-image').css('height', heightMainImage + 'px');
}else {
    heightMainImage = $('.main-image').width();
    $('.main-image').css('height', heightMainImage + 'px');
}

var loop = 1;
var left;
$('.thumb').click(function(){
    left = -heightMainImage*parseInt($(this).data('image'));
    console.log(left);
    $('.image-content').css('left', left + 'px');
    loop++;
})

menuToggle.addEventListener('click', function(){
    nav.classList.toggle('slide');
 });
