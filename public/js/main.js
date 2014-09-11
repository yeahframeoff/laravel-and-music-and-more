$(function(){
    // register all scripts

    Friends.init();
    registerNotification();
    registerImportController();
    registerPlayer();

    $('.raty-rated').raty({
        starOn  : 'public/images/star-on.png',
        starOff : 'public/images/star-off.png',
        score: function(){ return $(this).data('rate'); }
    });
});
