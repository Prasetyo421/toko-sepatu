console.log('ok');

const container = document.getElementsByClassName('container')[0];
const menuToggle = document.querySelector('.menu-toggle');
const nav = document.querySelector('.top-nav ul');
const spanMenuToggle = document.querySelector('.menu-toggle span');
const bar = document.getElementsByClassName('bars')[0];
const cancle = document.getElementsByClassName('cancle')[0];
const responsiveNav = document.getElementsByClassName('responsive-nav')[0];

var move = 0;

function pref (ele) {
   let type = ele.dataset.type;

   move = move +200;
   if (move <= 0) {
      let listSepatu = document.getElementsByClassName('list-sepatu-' + type)[0];
      listSepatu.style.left = move + 'px';
      console.log(listSepatu.style.left);
   }else {
      move = 0;
   }
}

function next (ele) {
   let type = ele.dataset.type;
   let listSepatu = document.getElementsByClassName('list-sepatu-' + type)[0];

   move = move + -200;
   if ((move + listSepatu.offsetWidth) > 0) {
      console.log(move + listSepatu.offsetWidth);
      listSepatu.style.left = move + 'px';
   }else {
      move = -1 * (listSepatu.offsetWidth - 200);
   }
}

let prefTest = document.getElementsByClassName('pref');


menuToggle.addEventListener('click', function(){
   nav.classList.toggle('slide');
});

window.addEventListener("scroll", function(){
   console.log('scroll');
   var topNav = document.getElementsByClassName("top-nav")[0];
   topNav.classList.toggle('sticky', window.scrollY > 0);
});
