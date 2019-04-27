    $("#panelfilter").click(function() {
        if ($("#formfilter").is(":hidden")) {
            $("#formfilter").slideDown("slow");
            $(".rotate").toggleClass("down")
        } else
        {
            $("#formfilter").slideUp("slow");
            $(".rotate").toggleClass("down")
        }
    });
