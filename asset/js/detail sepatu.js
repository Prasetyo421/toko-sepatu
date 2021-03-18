console.log('ok');

var thumb = document.getElementsByClassName('thumb');
var image = document.getElementsByClassName('main-image')[0];
var ajax = window.location.origin + '/toko-sepatu/asset/ajax/image.php';

var heightMainImage = $('.main-image').width();
$('.main-image').css('height', heightMainImage + 'px');

var loop = 1;
var left;
$('.thumb').click(function(){
    left = -heightMainImage*parseInt($(this).data('image'));
    console.log(left);
    $('.image-content').css('left', left + 'px');
    loop++;
})

// $('.thumb').click(function(){
//     console.log($(this).data('image'));
//     var index = $(this).data('image');
//     var id    = $(this).data('id');

//     // buat object ajax
//     var xhr = new XMLHttpRequest();

//     // cek kesiapan ajax
//     xhr.onreadystatechange = function(){
//         if(xhr.readyState == 4 && xhr.status == 200){
//             image.innerHTML = xhr.responseText;
//         }
//     }

//     // eksekusi ajax
//     xhr.open('GET', ajax + '?id=' + id + '&index=' + index, true);
//     xhr.send();
// })
