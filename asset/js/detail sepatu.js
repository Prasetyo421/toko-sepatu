console.log('ok');

let thumb = document.getElementsByClassName('thumb');
let image = document.getElementsByClassName('main-image')[0];
let ajax = window.location.origin + '/toko-sepatu/asset/ajax/image.php';
const menuToggle = document.querySelector('.menu-toggle');
const nav = document.querySelector('.top-nav ul');
let amount = document.getElementById('amount');
// let size = document.getElementById('size');
let body = document.getElementsByTagName('body')[0];
let mainImage = document.getElementsByClassName('main-image')[0];
let imageContent = document.getElementsByClassName('image-content')[0];
let size = document.getElementsByClassName('size');

function setSize(ele){
    console.log(ele);
    for (let i = 0; i < size.length; i++) {
        const element = size[i].style.color = "#929292";
    }
    ele.style.color = "black";
    let data = ele.dataset.size;
    size.value = data;
    console.log(data);
}

var amountNow = 1;
amount.value = `${amountNow}`;
console.log(amountNow);
function amountUp() {
    amountNow++;
    console.log('up');
    amount.value = amountNow;
}

function amountDown() {
    if (amountNow > 1) {
        amountNow--;
        console.log('down');
        amount.value = amountNow;
    }
}

let heightMainImage = 0;
if (body.offsetWidth < 576) {
    heightMainImage = body.offsetWidth;
    mainImage.style.height = heightMainImage + 'px';
}else {
    heightMainImage = mainImage.offsetWidth;
    mainImage.style.height = heightMainImage + 'px';
}

// if($('body').width() < 576){
//     heightMainImage = $('body').width();
//     $('.main-image').css('height', heightMainImage + 'px');
// }else {
//     heightMainImage = $('.main-image').width();
//     $('.main-image').css('height', heightMainImage + 'px');
// }

let loop = 1;
let left;

for (let i = 0; i < thumb.length; i++) {
    thumb[i].addEventListener('mouseover', thumbMouseover);
}

function thumbMouseover(){
    console.log('click');
    left = -heightMainImage*parseInt(this.dataset.image);
    console.log(left);
    imageContent.style.left = left + 'px';
    loop++;
}

menuToggle.addEventListener('click', function(){
    nav.classList.toggle('slide');
 });
