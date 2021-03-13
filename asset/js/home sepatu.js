console.log('ok');

const menuToggle = document.querySelector('.menu-toggle');
const nav = document.querySelector('.top-nav ul');
const spanMenuToggle = document.querySelector('.menu-toggle span');

menuToggle.addEventListener('click', function(){
   nav.classList.toggle('slide');
});

window.addEventListener("scroll", function(){
   var topNav = document.getElementsByClassName("top-nav")[0];
   topNav.classList.toggle('sticky', window.scrollY > 0);
})

$(".bars").click(function(){
   $(this).hide();
   $(".responsive-nav").show();
   $(".container").css('width', '100vh');
   $(".container").css('overflow', 'hidden');
});

$(".cancle").click(function(){
   $(".responsive-nav").hide();
   $(".bars").show();
});

