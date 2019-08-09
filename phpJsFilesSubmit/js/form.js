jQuery(document).ready(function($){

  $('#buttonid').on('click',function(e){
    e.preventDefault();
     $('.ajaxsend').submit();
 });




   $(".ajaxsend").submit(function() {
   	var formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: "contacts.php",
            data: new FormData( this ),
                  processData: false,
                  contentType: false
        }).done(function() {
            $(this).find("input").val("");
            $("#done").fadeIn(1000);
            setTimeout(function() {
                $("#done").fadeOut(1000)
            }, 3000);
            $(".ajaxsend").trigger("reset");
        });
        return false;
    });









});