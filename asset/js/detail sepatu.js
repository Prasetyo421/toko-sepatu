console.log('ok');

const thumb = document.getElementsByClassName('thumb');
const image = document.getElementsByClassName('main-image')[0];
const ajax = window.location.origin + '/toko-sepatu/asset/ajax/image.php';
const amount = document.getElementById('amount');
const body = document.getElementsByTagName('body')[0];
const mainImage = document.getElementsByClassName('main-image')[0];
const imageContent = document.getElementsByClassName('image-content')[0];
const size = document.getElementsByClassName('size');
const inputSize = document.getElementById('size');

function setSize(ele){
    console.log(ele);
    for (let i = 0; i < size.length; i++) {
        const element = size[i].style.color = "#929292";
    }
    ele.style.color = "black";
    let data = ele.dataset.size;
    inputSize.value = data;
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
