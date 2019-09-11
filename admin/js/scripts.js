$(document).ready(function() {

    // EDITOR CKEDITOR
ClassicEditor
    .create( document.querySelector( '#body' ) )
    .catch( error => {
        console.error( error );
    } );
// REST OF CODE
    $('#selectAllBoxes').click(function(event){
        if (this.checked) {
            $('.checkBoxes').each(function () {
                this.checked = true;
            });
        } else {
            $('.checkBoxes').each(function () {
                this.checked = false;
            });
        }
    });
});

function loadUsersOnline() {
    $.get("functions.php?onlineusers=result", function(data){
        $(".usersonline").text(data);
    });
}

setInterval(function () {
    loadUsersOnline();
},500);