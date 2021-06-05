console.log('ok');

let thumb = document.getElementsByClassName('thumb');
let image = document.getElementsByClassName('main-image')[0];
let ajax = window.location.origin + '/toko-sepatu/asset/ajax/image.php';
const menuToggle = document.querySelector('.menu-toggle');
const nav = document.querySelector('.top-nav ul');
let amount = document.getElementById('amount');
let size = document.getElementById('size');

function setSize(ele){
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
    // amount.innerHTML = `${amountNow}`;
    amount.value = amountNow;
}

function amountDown() {
    if (amountNow > 1) {
        amountNow--;
        console.log('down');
        // amount.innerHTML = `${amountNow}`;
        amount.value = amountNow;
    }
}

let heightMainImage = 0;
if($('body').width() < 576){
    heightMainImage = $('body').width();
    $('.main-image').css('height', heightMainImage + 'px');
}else {
    heightMainImage = $('.main-image').width();
    $('.main-image').css('height', heightMainImage + 'px');
}

let loop = 1;
let left;
$('.thumb').click(function(){
    left = -heightMainImage*parseInt($(this).data('image'));
    console.log(left);
    $('.image-content').css('left', left + 'px');
    loop++;
})

menuToggle.addEventListener('click', function(){
    nav.classList.toggle('slide');
 });
