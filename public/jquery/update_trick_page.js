$(document).ready(function() {

    var picturesnumber = $("#counter div.to-count").length / 3;

    for (let i = 0; i < picturesnumber; i++) {

        $("#" + i + "_modify").hide(0);
        $("#" + i + "_delete").hide(0);

        $("#modify").click(function(){
            $("#" + i).hide(0);
            $("#" + i + "_modify").show(0);
        });

        $("#delete").click(function(){
            $("#" + i).hide(0);
            $("#" + i + "_delete").show(0);
        });
    }
});