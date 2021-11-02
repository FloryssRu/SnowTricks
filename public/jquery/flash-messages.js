$(document).ready(function(){

    var flash_messages_number = $(".flash-container div.flash").length;

    for (let i = 0; i < flash_messages_number; i++) {

        $("#" + i + "_close").click(function(){
            $("#" + i + "_flash").animate({opacity: '0', height: '0', margin: '0px', padding: '0px'}, 400);
        });

    }
});