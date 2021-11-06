$(document).ready(function() {

    $("#show_medias").click(function(){
        $("#medias").toggle(0);

        if ($("#show_medias").html() == "Voir les médias") {
            $("#show_medias").html("Cacher les médias");
        } else {
            $("#show_medias").html("Voir les médias");
        }
    });

});