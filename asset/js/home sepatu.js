console.log('ok');

const container = document.getElementsByClassName('container')[0];
const menuToggle = document.querySelector('.menu-toggle');
const nav = document.querySelector('.top-nav ul');
const spanMenuToggle = document.querySelector('.menu-toggle span');
const bar = document.getElementsByClassName('bars')[0];
const cancle = document.getElementsByClassName('cancle')[0];
const responsiveNav = document.getElementsByClassName('responsive-nav')[0];

var move = 0;
var widthListSepatu = $('.list-sepatu').width();
var width = $('.item').width();
console.log(width);

$('.pref').click(function(){
   var type = $(this).data('type');
   move = move + 200;
   if( move <= 0){
      $('.list-sepatu-' + type).css('left', move + 'px');
   }else {
      move = 0;
   }
})

$('.next').click(function(){
   var type = $(this).data('type');
   move = move + -200;
   if ( (move + $('.list-sepatu-' + type).width()) > 0){
      console.log($('.list-sepatu-' + type).width());
      $('.list-sepatu-' + type).css('left', move + 'px');
   }else {
      move = -1 * ($('.list-sepatu-' + type).width() - 200);
   }
})

menuToggle.addEventListener('click', function(){
   nav.classList.toggle('slide');
});

window.addEventListener("scroll", function(){
   var topNav = document.getElementsByClassName("top-nav")[0];
   topNav.classList.toggle('sticky', window.scrollY > 0);
});

$('.bars').click(function(){
   console.log('ok');
   $(this).hide();
   responsiveNav.style.display = 'block';
   responsiveNav.style.display = 'block';
   container.style.width = '100vh';
   container.style.overflow = 'hidden';
})

$('.cancle').click(function(){
   responsiveNav.style.display = 'none';
   $('.bars').css('display', 'block');
})

