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

$('.pref').click(function(){
   move = move + 200;
   $('.list-sepatu').css('left', move + 'px');
})

$('.next').click(function(){
   move = move + -200;
   $('.list-sepatu').css('left', move + 'px');
})

// $('.pref').click(function(){
//    i++;
//    // j=0;
//    moveL = (-move*i) + (move*j)
//    $('.list-sepatu').css('left', -moveL + 'px');
//    $('.list-sepatu').css('right', 0 + 'px');
//    console.log(moveL);

// })

// $('.next').click(function(){
//    j++;
//    // i=0;
//    moveR = (-move*j) + (move*i);
//    $('.list-sepatu').css('right', moveR + 'px');
//    $('.list-sepatu').css('left', 0 + 'px');
//    console.log(moveR);

// })

menuToggle.addEventListener('click', function(){
   nav.classList.toggle('slide');
});

window.addEventListener("scroll", function(){
   var topNav = document.getElementsByClassName("top-nav")[0];
   topNav.classList.toggle('sticky', window.scrollY > 0);
});

bar.addEventListener('click', function(){
   console.log('ok');
   bars.style.display = 'none';
   responsiveNav.style.display = 'block';
   container.style.width = '100vh';
   container.style.overflow = 'hidden';
});

cancle.addEventListener('click', function(){
   responsiveNav.style.display = 'none';
   bars.style.display = 'block';
});

// $(".bars").click(function(){
//    $(this).hide();
//    $(".responsive-nav").show();
//    $(".container").css('width', '100vh');
//    $(".container").css('overflow', 'hidden');
// });

// $(".cancle").click(function(){
//    $(".responsive-nav").hide();
//    $(".bars").show();
// });

