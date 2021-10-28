$(document).ready(function() {

    $("#followingtricks").hide(0);
    var tricks = $("#tricks article");

    if (tricks.length > 15) {
        $("article:gt(14)").hide(0);
        $("#followingtricks").show(0);
        var tricks_show = 15;

        $("#followingtricks").click(function(){
            $("article").slice(tricks_show, tricks_show+15).show(0);
            tricks_show = tricks_show + 15;
            
            if (tricks.length <= tricks_show) {
                $("#followingtricks").hide(0);
            }
        });
    }
});
