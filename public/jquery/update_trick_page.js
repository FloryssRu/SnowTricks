$(document).ready(function() {

    var picturesnumber = $("#counter div.to-count").length / 3;

    for (let i = 0; i < picturesnumber; i++) {

        $("#" + i + "_modify").hide(0);
        $("#" + i + "_delete").hide(0);

        $("#clicker_" + i + "_modify").click(function(){
            $("#" + i).hide(0);
            $("#" + i + "_modify").show(0);
        });

        $("#clicker_" + i + "_modify-cancel").click(function(){
            $("#" + i).show(0);
            $("#" + i + "_modify").hide(0);
        });

        $("#clicker_" + i + "_delete").click(function(){
            $("#" + i).remove(0);
            $("#" + i + "_modify").remove(0);
        });
    }
});