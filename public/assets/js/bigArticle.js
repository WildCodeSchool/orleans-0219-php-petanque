$(document).ready(() => {
    $('.info_article_big').hover(function () {
        $('.article_tag_and_title_big').animate({"bottom":"80px"});
        $('.hover_content_big_article').toggleClass("no_display");
    }, function () {
        $('.article_tag_and_title_big',this).animate({"bottom":"0px"}, function() {
            $('.hover_content_big_article',this).toggleClass("no_display");
        });
    });
});