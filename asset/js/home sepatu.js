console.log('ok');

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


