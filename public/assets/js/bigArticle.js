$(document).ready(() => {
    $('.info_article_big').hover(() => {
        $('.article_tag_and_title_big').animate({"bottom":"80px"});
        $('.hover_content_big_article').toggleClass("no_display");
    }, () => {
        $('.article_tag_and_title_big',this).animate({"bottom":"0px"}, () => {
            $('.hover_content_big_article',this).toggleClass("no_display");
        });
    });
});