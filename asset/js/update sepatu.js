var i = 1;
$('#add').click(function(){
    $('#dynamic_field').append(`<tr id="row` + i + `">
    <td><input type="text" name="spesifikasi[]"></td>
    <td><button class="btn_remove" type="button" id="`+ i +`">remove</button></td>>
</tr>`);
i++;
});

$(document).on('click', '.btn_remove', function(){  
    var button_id = $(this).attr("id");   
    $('#row'+button_id+'').remove();  
});  

$('#image').change(function(){
    var jumlahGambar = $('input:file')[0].files.length;
    console.log(jumlahGambar);

    for (let i = 0; i < jumlahGambar; i++) {
        $('#image-preview').append("<img src='"+URL.createObjectURL(event.target.files[i])+"'>");
    }

});