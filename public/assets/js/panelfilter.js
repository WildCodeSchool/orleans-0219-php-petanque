    $("#panelfilter").click(function() {
        if ($("#formfilter").is(":hidden")) {
            $("#formfilter").slideDown("slow");
        } else
        {
            $("#formfilter").slideUp("slow");
        }
    });
