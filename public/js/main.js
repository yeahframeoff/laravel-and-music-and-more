$(function() {

    $('.addTrack').on('click', function(){
        if ($(this).find('span:first').hasClass('glyphicon-ok'))
            return 0;

        var id = $(this).attr('data-id');
        var a = $(this);
        $.get('/importTrack/' + id)
            .success(function(data){
                $(a).find('span:first').attr('class', 'glyphicon glyphicon-ok');
                $(a).removeClass('addTrack');
            })
            .fail(function(data){
                console.log(data);
            });
    });

});