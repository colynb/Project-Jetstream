$(function () {
    SyntaxHighlighter.all()
    $('.shutdown-error').css('display','none');
    var content = $('.shutdown-error').html();
    if (content) $('body').prepend('<div class="shutdown-error">'+content+'</div>');
});