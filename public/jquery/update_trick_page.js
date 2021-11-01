$(document).ready(function() {

    var pictures_number = $("#counter div").lenght / 3 + 1; /* le nombre de div dans .flexbox-tight /3 */
    /* $("#counter div").lenght         est undefined */

    for (let i = 0; i < pictures_number; i++) {
        document.write("je passe ! ");
        $("#" + i + "_modify").hide(0);
        $("#" + i + "_delete").hide(0);

        $("#" + i + "_modify").click(function(){
            $("#" + i).hide(0);
            $("#" + i + "_modify").show(0);
        });

        $("#" + i + "_delete").click(function(){
            $("#" + i).hide(0);
            $("#" + i + "_delete").show(0);
        });
    }
});